<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface;
use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;
use Propel\Runtime\Map\TableMap;

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
     * ContentfulPageSearchWriter constructor.
     *
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery $contentfulPageSearchQuery
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface $searchFacade
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface $utilEncoding
     */
    public function __construct(
        FosContentfulQuery $contentfulQuery,
        FosContentfulPageSearchQuery $contentfulPageSearchQuery,
        ContentfulPageSearchToSearchFacadeInterface $searchFacade,
        ContentfulPageSearchToUtilEncodingInterface $utilEncoding
    ) {
        $this->contentfulQuery = $contentfulQuery;
        $this->contentfulPageSearchQuery = $contentfulPageSearchQuery;
        $this->searchFacade = $searchFacade;
        $this->utilEncoding = $utilEncoding;
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

        $contentfulData = $contentfulEntity->toArray(TableMap::TYPE_FIELDNAME, true, [], true);
        $data = $this->mapToSearchData($contentfulData, $contentfulEntity->getEntryLocale());

        $contentfulPageSearchEntity->setData($data);
        $contentfulPageSearchEntity->setStructuredData($this->utilEncoding->encodeJson($contentfulData));
        $contentfulPageSearchEntity->setFkContentful($contentfulId);
        $contentfulPageSearchEntity->setLocale($contentfulEntity->getEntryLocale());
        $contentfulPageSearchEntity->save();
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
