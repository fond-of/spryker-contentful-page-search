<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency;

interface ContentfulEvents
{
    public const ENTITY_FOS_CONTENTFUL_PAGE_CREATE = 'Entity.fob_contentful_page.create';

    public const ENTITY_FOS_CONTENTFUL_PAGE_UPDATE = 'Entity.fob_contentful_page.update';

    public const ENTITY_FOS_CONTENTFUL_PAGE_DELETE = 'Entity.fob_contentful_page.delete';

    public const ENTITY_FOS_CONTENTFUL_PAGE_UNPUBLISH = 'Entity.fob_contentful_page.unpublish';

    public const ENTITY_FOS_CONTENTFUL_PAGE_PUBLISH = 'Entity.fob_contentful_page.publish';
}
