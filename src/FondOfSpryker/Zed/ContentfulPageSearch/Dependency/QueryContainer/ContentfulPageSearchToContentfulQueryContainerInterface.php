<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer;

use Orm\Zed\Contentful\Persistence\FosContentful;

interface ContentfulPageSearchToContentfulQueryContainerInterface
{
    /**
     * @param string $contentfulEntryId
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful|null
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId): ?FosContentful;

    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntryByIds(array $contentfulEntryIds): ?array;
}
