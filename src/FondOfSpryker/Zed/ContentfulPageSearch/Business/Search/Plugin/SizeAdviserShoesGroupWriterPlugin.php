<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriterPluginInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;

class SizeAdviserShoesGroupWriterPlugin extends AbstractEntryTypePlugin implements ContentfulPageSearchWriterPluginInterface
{
    private $entryTypeId = 'sizeAdviserShoesGroup';

    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return $this->entryTypeId;
    }

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $contentfulEntity
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch $contentfulPageSearchEntity
     *
     * @return void
     */
    public function extractEntry(FosContentful $contentfulEntity, FosContentfulPageSearch $contentfulPageSearchEntity): void
    {
        $this->store($contentfulEntity, $contentfulPageSearchEntity);
    }
}
