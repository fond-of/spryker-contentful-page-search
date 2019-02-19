<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

interface ContentfulTypeMapperPluginInterface
{
    /**
     * @return string
     */
    public function getEntryTypeId(): string;

    /**
     * @param int $idContetful
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function handle(int $idContetful, PageMapTransfer $pageMapTransfer, PageMapBuilderInterface $pageMapBuilder, array $data): PageMapTransfer;

    /**
     * @param array $storageEntry
     *
     * @return array
     */
    public function extractEntries(array $storageEntry): array;
}
