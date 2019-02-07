<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Persistence;

use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface ContentfulPageSearchQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulPageSearchByIds(array $contentfulEntryIds): FosContentfulQuery;
}
