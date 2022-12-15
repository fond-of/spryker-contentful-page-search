<?php

namespace FondOfSpryker\Shared\ContentfulPageSearch;

interface ContentfulPageSearchConstants
{
    /**
     * @var string
     */
    public const CONTENTFUL_RESOURCE_NAME = 'contentful_page';

    /**
     * @var string
     */
    public const CONTENTFUL_SYNC_SEARCH_QUEUE = 'sync.search.contentful';

    /**
     * @var string
     */
    public const CONTENTFUL_SYNC_SEARCH_QUEUE_ERROR = 'sync.search.contentful.error';

    /**
     * @var string
     */
    public const BLOG_PAGINATION_ITEMS_PER_PAGE = 'BLOG_PAGINATION_ITEMS_PER_PAGE';

    /**
     * @var string
     */
    public const BLOG_BLOG_PAGINATION_PAGE_REQ_PARAM = 'page';

    /**
     * @var string
     */
    public const STORE_NAME_FIELD = 'store_name';
}
