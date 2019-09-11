<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin;

use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Exception\StoreNotFoundException;
use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;
use Propel\Runtime\Map\TableMap;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Store\Business\StoreFacade;

/**
 * Class AbstractEntryTypePlugin
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin
 */
abstract class AbstractEntryTypePlugin
{
    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface
     */
    protected $storageFacade;

    /**
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $contentfulQuery;

    /**
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface $storageFacade
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface $searchFacade
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     */
    public function __construct(
        ContentfulPageSearchToStorageFacadeInterface $storageFacade,
        ContentfulPageSearchToSearchFacadeInterface $searchFacade,
        FosContentfulQuery $contentfulQuery
    ) {
        $this->storageFacade = $storageFacade;
        $this->searchFacade = $searchFacade;
        $this->contentfulQuery = $contentfulQuery;
    }

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $contentfulEntity
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch $contentfulPageSearchEntity
     * @param string $storeName
     *
     * @return void
     */
    protected function store(FosContentful $contentfulEntity, FosContentfulPageSearch $contentfulPageSearchEntity, string $storeName)
    {
        $contentfulData = $contentfulEntity->toArray(TableMap::TYPE_FIELDNAME, true, []);
        $contentfulData[ContentfulPageSearchConstants::STORE_NAME_FIELD] = $storeName;
        $data = $this->mapToSearchData($contentfulData, $contentfulEntity->getEntryLocale());

        $contentfulPageSearchEntity->setData($data);
        $contentfulPageSearchEntity->setStructuredData($contentfulEntity->getEntryData());
        $contentfulPageSearchEntity->setFkContentful($contentfulEntity->getIdContentful());
        $contentfulPageSearchEntity->setLocale($contentfulEntity->getEntryLocale());
        $contentfulPageSearchEntity->setStore($storeName);
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

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $contentfulEntity
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch $contentfulPageSearchEntity
     * @param string $storeName
     *
     * @return void
     */
    public function extractEntry(FosContentful $contentfulEntity, FosContentfulPageSearch $contentfulPageSearchEntity, string $storeName): void
    {
        $this->store($contentfulEntity, $contentfulPageSearchEntity, $storeName);
    }
}
