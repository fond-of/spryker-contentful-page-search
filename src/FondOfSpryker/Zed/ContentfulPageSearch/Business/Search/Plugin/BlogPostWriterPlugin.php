<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriterPluginInterface;

class BlogPostWriterPlugin extends AbstractEntryTypePlugin implements ContentfulPageSearchWriterPluginInterface
{
    /**
     * @var string
     */
    private $entryTypeId = 'blogPost';

    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return $this->entryTypeId;
    }
}
