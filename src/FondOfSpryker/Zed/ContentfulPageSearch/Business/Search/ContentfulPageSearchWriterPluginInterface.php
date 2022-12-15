<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;

interface ContentfulPageSearchWriterPluginInterface
{
    /**
     * @var string
     */
    public const FIELD_TYPE_REFERENCE = 'Reference';

    /**
     * @return string
     */
    public function getEntryTypeId(): string;

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $contentfulEntity
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch $contentfulPageSearchEntity
     * @param string $storeName
     *
     * @return void
     */
    public function extractEntry(FosContentful $contentfulEntity, FosContentfulPageSearch $contentfulPageSearchEntity, string $storeName): void;
}
