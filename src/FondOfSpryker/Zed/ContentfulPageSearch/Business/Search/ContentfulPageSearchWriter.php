<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface;
use Generated\Shared\Transfer\LocaleTransfer;
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
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchToSearchFacadeInterface
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
     * @var array
     */
    protected $contentfulPageSearchWriterPlugins;

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery $contentfulPageSearchQuery
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface $searchFacade
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface $storageFacade
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface $utilEncoding
     * @param array $contentfulPageSearchWriterPlugins
     */
    public function __construct(
        FosContentfulQuery $contentfulQuery,
        FosContentfulPageSearchQuery $contentfulPageSearchQuery,
        ContentfulPageSearchToSearchFacadeInterface $searchFacade,
        ContentfulPageSearchToStorageFacadeInterface $storageFacade,
        ContentfulPageSearchToUtilEncodingInterface $utilEncoding,
        array $contentfulPageSearchWriterPlugins
    ) {
        $this->contentfulQuery = $contentfulQuery;
        $this->contentfulPageSearchQuery = $contentfulPageSearchQuery;
        $this->searchFacade = $searchFacade;
        $this->utilEncoding = $utilEncoding;
        $this->storageFacade = $storageFacade;
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

        /** @var \Orm\Zed\Contentful\Persistence\FosContentful[] $contentfulEntries */
        $contentfulEntries = $this->contentfulQuery
            ->filterByIdContentful_In($contentfulEntryIds);

        /** @var \Orm\Zed\Contentful\Persistence\FosContentful $entry */
        foreach ($contentfulEntries as $entry) {
            $this->store($entry->getPrimaryKey());
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
            if ($contentfulEntity->getEntryTypeId() === $contentfulPageSearchWriterPlugin->getEntryTypeId()) {
                $contentfulPageSearchWriterPlugin->extractEntry(
                    $contentfulEntity,
                    $contentfulPageSearchEntity
                );
            }
        }
    }

    /**
     * @param array $fosContentfulData
     * @param string $localeName
     *
     * @return array
     */
    public function mapToSearchData(array $fosContentfulData, string $localeName): array
    {
        return $this->searchFacade->transformPageMapToDocumentByMapperName(
            $fosContentfulData,
            (new LocaleTransfer())->setLocaleName($localeName),
            ContentfulPageSearchConstants::CONTENTFUL_RESOURCE_NAME
        );
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
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\Base\FosContentfulPageSearch
     */
    protected function getContentfulPageSearchEntity(int $contentfulId): FosContentfulPageSearch
    {
        $this->contentfulPageSearchQuery->clear();

        return $this->contentfulPageSearchQuery
            ->filterByFkContentful($contentfulId)
            ->findOneOrCreate();
    }
}
