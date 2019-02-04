<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

interface ContentfulPageSearchWriterInterface
{
    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function publish(array $contentfulEntryIds): void;

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function unpublish(array $contentfulEntryIds): void;
}
