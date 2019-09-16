<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriterPluginInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search\BlogPostPageMapPlugin;

class BlogPostWriterPlugin extends AbstractEntryTypePlugin implements ContentfulPageSearchWriterPluginInterface
{
    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return BlogPostPageMapPlugin::ENTRY_TYPE_ID_VALUE;
    }
}
