<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

interface ContentfulPageSearchWriterPluginInterface
{
    /**
     * @return string
     */
    public function getEntryTypeId(): string;
}
