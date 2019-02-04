<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface ContentfulPageSearchQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntriesByIds(array $contentfulEntryIds): ?array;
}
