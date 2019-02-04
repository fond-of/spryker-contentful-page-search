<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Persistence;

use FondOfSpryker\Zed\ContentfulPageSearch\ContentfulPageSearchDependencyProvider;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer\ContentfulPageSearchToContentfulEntryQueryContainerInterface;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchQueryContainer getQueryContainer()
 */
class ContentfulPageSearchPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery
     */
    public function createFobContentfulPageSearchQuery(): FosContentfulPageSearchQuery
    {
        return FosContentfulPageSearchQuery::create();
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer\ContentfulPageSearchToContentfulEntryQueryContainerInterface
     */
    public function getContentfulEntryQueryContainer(): ContentfulPageSearchToContentfulEntryQueryContainerInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::QUERY_CONTAINER_CONTENTFUL_ENTRY);
    }
}
