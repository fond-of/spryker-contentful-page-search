<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

use Exception;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStoreFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Exception\StoreNotFoundException;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;

class ContentfulPageSearchWriter implements ContentfulPageSearchWriterInterface
{
    /**
     * @var \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery
     */
    protected $contentfulPageSearchQuery;

    /**
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $contentfulQuery;

    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface
     */
    protected $searchFacade;

    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface
     */
    protected $utilEncoding;

    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface
     */
    protected $storageFacade;

    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var array
     */
    protected $contentfulPageSearchWriterPlugins;

    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface
     */
    protected $structureValidatorCollection;

    /**
     * @var array
     */
    protected $storeNameChache = [];

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery $contentfulPageSearchQuery
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface $searchFacade
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface $storageFacade
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface $utilEncoding
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStoreFacadeInterface $storeFacade
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface $structureValidatorCollection
     * @param array $contentfulPageSearchWriterPlugins
     */
    public function __construct(
        FosContentfulQuery $contentfulQuery,
        FosContentfulPageSearchQuery $contentfulPageSearchQuery,
        ContentfulPageSearchToSearchFacadeInterface $searchFacade,
        ContentfulPageSearchToStorageFacadeInterface $storageFacade,
        ContentfulPageSearchToUtilEncodingInterface $utilEncoding,
        ContentfulPageSearchToStoreFacadeInterface $storeFacade,
        StructureValidatorCollectionInterface $structureValidatorCollection,
        array $contentfulPageSearchWriterPlugins
    ) {
        $this->contentfulQuery = $contentfulQuery;
        $this->contentfulPageSearchQuery = $contentfulPageSearchQuery;
        $this->searchFacade = $searchFacade;
        $this->utilEncoding = $utilEncoding;
        $this->storageFacade = $storageFacade;
        $this->storeFacade = $storeFacade;
        $this->structureValidatorCollection = $structureValidatorCollection;
        $this->contentfulPageSearchWriterPlugins = $contentfulPageSearchWriterPlugins;
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function publish(array $contentfulEntryIds): void
    {
        $this->contentfulPageSearchQuery->clear();

        /** @var array<\Orm\Zed\Contentful\Persistence\FosContentful> $contentfulEntries */
        $contentfulEntries = $this->contentfulQuery
            ->filterByIdContentful_In($contentfulEntryIds);

        /** @var \Orm\Zed\Contentful\Persistence\FosContentful $entry */
        foreach ($contentfulEntries as $entry) {
            $this->store((int)$entry->getPrimaryKey());
        }
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function unpublish(array $contentfulEntryIds): void
    {
    }

    /**
     * @param int $contentfulId
     *
     * @return void
     */
    protected function store(int $contentfulId): void
    {
        $contentfulEntity = $this->getContentfulEntity($contentfulId);
        $contentfulPageSearchEntity = $this->getContentfulPageSearchEntity($contentfulId);

        /** @var \FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriterPluginInterface $contentfulPageSearchWriterPlugin */
        foreach ($this->contentfulPageSearchWriterPlugins as $contentfulPageSearchWriterPlugin) {
            $validator = $this->getValidator($contentfulPageSearchWriterPlugin->getEntryTypeId());

            if ($contentfulEntity->getEntryTypeId() === $contentfulPageSearchWriterPlugin->getEntryTypeId() && $validator !== null && $validator->validate($contentfulEntity->getEntryData())) {
                $contentfulPageSearchWriterPlugin->extractEntry(
                    $contentfulEntity,
                    $contentfulPageSearchEntity,
                    $this->getStoreNameById($contentfulEntity->getFkStore()),
                );
            }
        }
    }

    /**
     * @param string $validatorName
     *
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface|null
     */
    protected function getValidator(string $validatorName): ?StructureValidatorInterface
    {
        $validator = null;

        if ($this->structureValidatorCollection->has($validatorName)) {
            $validator = $this->structureValidatorCollection->get($validatorName);
        }

        return $validator;
    }

    /**
     * @param int $contentfulId
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful
     */
    protected function getContentfulEntity(int $contentfulId): FosContentful
    {
        $this->contentfulQuery->clear();

        return $this->contentfulQuery
            ->filterByIdContentful($contentfulId)
            ->findOne();
    }

    /**
     * @param int $contentfulId
     *
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch
     */
    protected function getContentfulPageSearchEntity(int $contentfulId): FosContentfulPageSearch
    {
        $this->contentfulPageSearchQuery->clear();

        return $this->contentfulPageSearchQuery
            ->filterByFkContentful($contentfulId)
            ->findOneOrCreate();
    }

    /**
     * @param int $storeId
     *
     * @throws \FondOfSpryker\Zed\ContentfulPageSearch\Exception\StoreNotFoundException
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @return string
     */
    protected function getStoreNameById(int $storeId): string
    {
        if (!array_key_exists($storeId, $this->storeNameChache)) {
            $store = $this->storeFacade->getStoreById($storeId);
            $this->storeNameChache[$storeId] = $store->getName();
        }

        if (array_key_exists($storeId, $this->storeNameChache)) {
            return $this->storeNameChache[$storeId];
        }

        throw new StoreNotFoundException(sprintf('Store with id %s not found!', $storeId));
    }
}
