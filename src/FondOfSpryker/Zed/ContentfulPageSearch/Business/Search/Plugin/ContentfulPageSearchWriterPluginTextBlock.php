<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriterPluginInterface;

class ContentfulPageSearchWriterPluginTextBlock implements ContentfulPageSearchWriterPluginInterface
{
    public const ENTRY_TYPE_ID = 'textBlock';

    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return static::ENTRY_TYPE_ID;
    }
}
