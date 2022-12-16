<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Persistence;

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
}
