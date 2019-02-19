<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer;

use Orm\Zed\ContentfulPage\Persistence\FosContentfulEntry;

interface ContentfulPageSearchToContentfulEntryQueryContainerInterface
{
    /**
     * @param string $contentfulEntryId
     *
     * @return \Orm\Zed\ContentfulPage\Persistence\FosContentfulEntry|null
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId): ?FosContentfulEntry;

    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntryByIds(array $contentfulEntryIds): ?array;
}
