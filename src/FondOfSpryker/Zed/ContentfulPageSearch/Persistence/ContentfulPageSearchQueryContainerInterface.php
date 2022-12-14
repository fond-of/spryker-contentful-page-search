<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Persistence;

use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface ContentfulPageSearchQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param  array  $contentfulEntryIds
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery
     */
    public function queryContentfulPageSearchByIds(array $contentfulEntryIds): FosContentfulPageSearchQuery;
}
