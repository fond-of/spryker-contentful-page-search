<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency;

interface ContentfulEvents
{
    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_PAGE_CREATE = 'Entity.fob_contentful_page.create';

    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_PAGE_UPDATE = 'Entity.fob_contentful_page.update';

    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_PAGE_DELETE = 'Entity.fob_contentful_page.delete';

    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_PAGE_UNPUBLISH = 'Entity.fob_contentful_page.unpublish';

    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_PAGE_PUBLISH = 'Entity.fob_contentful_page.publish';
}
