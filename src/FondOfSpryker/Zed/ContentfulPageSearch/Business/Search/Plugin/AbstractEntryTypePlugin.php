<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin;

use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;
use Propel\Runtime\Map\TableMap;

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
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     */
    public function __construct(
        ContentfulPageSearchToStorageFacadeInterface $storageFacade,
        FosContentfulQuery $contentfulQuery
    ) {
        $this->storageFacade = $storageFacade;
        $this->contentfulQuery = $contentfulQuery;
    }

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $contentfulEntity
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch $contentfulPageSearchEntity
     *
     * @return void
     */
    protected function store(FosContentful $contentfulEntity, FosContentfulPageSearch $contentfulPageSearchEntity)
    {
        $contentfulData = $contentfulEntity->toArray(TableMap::TYPE_FIELDNAME, true, [], true);
        $data = $this->mapToSearchData($contentfulData, $contentfulEntity->getEntryLocale());

        $contentfulPageSearchEntity->setData($data);
        $contentfulPageSearchEntity->setStructuredData($contentfulEntity->getEntryData());
        $contentfulPageSearchEntity->setFkContentful($contentfulEntity->getIdContentful());
        $contentfulPageSearchEntity->setLocale($contentfulEntity->getEntryLocale());
        $contentfulPageSearchEntity->save();
    }
}
