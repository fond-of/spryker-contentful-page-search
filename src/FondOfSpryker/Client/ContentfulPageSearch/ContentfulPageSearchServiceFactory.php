<?php

namespace FondOfSpryker\Service\ContentfulPageSearch;

use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Service\Kernel\AbstractServiceFactory;

class ContentfulPageSearchServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    public function createFosContentfulQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }
}
