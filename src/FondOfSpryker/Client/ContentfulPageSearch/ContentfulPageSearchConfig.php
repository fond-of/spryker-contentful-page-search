<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use Spryker\Client\Kernel\AbstractBundleConfig;

class ContentfulPageSearchConfig extends AbstractBundleConfig
{
    /**
     * @return int
     */
    public function getBlogPaginationItemsPerPage(): int
    {
        return $this->get(ContentfulPageSearchConstants::BLOG_PAGINATION_ITEMS_PER_PAGE, 6);
    }
}
