<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;
use Spryker\Client\Search\Dependency\Plugin\SearchConfigInterface;
use Spryker\Client\Search\Dependency\Plugin\SearchStringSetterInterface;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilderInterface;
use Spryker\Client\Search\Plugin\Config\SearchConfig;
use Spryker\Client\Search\SearchClientInterface;

class ContentfulPageSearchFactory extends AbstractFactory
{
    /**
     * @var \Spryker\Client\Search\Dependency\Plugin\SearchConfigInterface
     */
    protected static $searchConfigInstance;

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
     * @return \Spryker\Client\Search\Dependency\Plugin\SearchConfigInterface
     */
    public function createSearchConfig(): SearchConfigInterface
    {
        return new SearchConfig();
    }

    /**
     * @param string $searchString
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function createContentfulSearchQuery(string $searchString): QueryInterface
    {
        $searchQuery = $this->getContentfulSearchQueryPlugin();

        if ($searchQuery instanceof SearchStringSetterInterface) {
            $searchQuery->setSearchString($searchString);
        }

        return $searchQuery;
    }

    /**
     * @return \Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilderInterface
     */
    public function createQueryBuilder(): QueryBuilderInterface
    {
        return new QueryBuilder();
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function getContentfulSearchQueryPlugin(): QueryInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_QUERY_PLUGIN);
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    public function getSearchClient(): SearchClientInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CLIENT_SEARCH);
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    public function getContentfulSearchBlogCategoryQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_CATEGORY_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    public function getContentfulSearchBlogTagQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_TAG_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    public function getContentfulSearchCategoryNodeQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    public function getContentfulSearchBlogCategoryFormatterPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    public function getContentfulSearchBlogTagFormatterPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_TAG_RESULT_FORMATTER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    public function getContentfulSearchCategoryNodeFormatterPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_FORMATTER_PLUGINS);
    }

    /**
     * @return \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchConfig
     */
    public function getContentfulPageSearchConfig(): ContentfulPageSearchConfig
    {
        return $this->getConfig();
    }
}
