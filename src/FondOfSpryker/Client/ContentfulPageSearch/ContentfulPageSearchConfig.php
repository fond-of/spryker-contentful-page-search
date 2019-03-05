<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use Pyz\Client\Search\SearchConfig;
use Spryker\Client\Kernel\AbstractBundleConfig;

class ContentfulPageSearchConfig extends AbstractBundleConfig
{
    /**
     * @var \Spryker\Client\Search\Dependency\Plugin\SearchConfigInterface
     */
    protected static $searchConfigInstance;

    /**
     * @return int
     */
    public function getBlogPaginationItemsPerPage(): int
    {
        return $this->get(ContentfulPageSearchConstants::BLOG_PAGINATION_ITEMS_PER_PAGE, 6);
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\SearchConfigInterface
     */
    public function getSearchConfig()
    {
        if (static::$searchConfigInstance === null) {
            static::$searchConfigInstance = $this->createSearchConfig();
        }

        return static::$searchConfigInstance;
    }

    /**
     * @return \Pyz\Client\Search\SearchConfig
     */
    public function createSearchConfig(): AbstractBundleConfig
    {
        return new SearchConfig();
    }
}
