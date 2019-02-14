<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;

interface ContentfulPageSearchWriterPluginInterface
{
    public const FIELD_TYPE_REFERENCE = 'Reference';

    /**
     * @return string
     */
    public function getEntryTypeId(): string;

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $fosContentful
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch $contentfulPageSearch
     *
     * @return void
     */
    public function extractEntry(FosContentful $fosContentful, FosContentfulPageSearch $contentfulPageSearch): void;
}
