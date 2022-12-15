<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Search\SearchClientInterface;
use Spryker\Client\SearchElasticsearch\Query\QueryBuilder;
use Spryker\Client\SearchElasticsearch\Query\QueryBuilderInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchStringSetterInterface;

/**
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchConfig getConfig()
 */
class ContentfulPageSearchFactory extends AbstractFactory
{
    /**
     * @param string $searchString
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
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
     * @return \Spryker\Client\SearchElasticsearch\Query\QueryBuilderInterface
     */
    public function createQueryBuilder(): QueryBuilderInterface
    {
        return new QueryBuilder();
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
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
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    public function getContentfulSearchBlogCategoryQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_CATEGORY_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    public function getContentfulSearchBlogTagQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_TAG_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    public function getContentfulSearchCategoryNodeQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    public function getContentfulSearchBlogCategoryFormatterPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    public function getContentfulSearchBlogTagFormatterPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::CONTENTFUL_SEARCH_BLOG_TAG_RESULT_FORMATTER_PLUGINS);
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
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
