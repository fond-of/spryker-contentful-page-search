<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

interface ContentfulTypeMapperPluginInterface
{
    /**
     * @return string
     */
    public function getEntryTypeId(): string;

    /**
     * @param int $idContetful
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     *
     * @return array
     */
    public function handle(int $idContetful, PageMapBuilderInterface $pageMapBuilder): array;

    /**
     * @param array $storageEntry
     *
     * @return array
     */
    public function extractEntries(array $storageEntry): array;
}
