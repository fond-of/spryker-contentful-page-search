<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\BlogCategoryQueryExpander;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\BlogPaginatedQueryExpanderPlugin;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\BlogPostQueryExpander;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\BlogSortQueryExpander;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\BlogTagQueryExpander;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\CategoryNodeQueryExpanderPlugin;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\ContentfulSearchQueryPlugin;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter\BlogPaginatedResultFormatterPlugin;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter\BlogPostResultFormatterPlugin;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter\CategoryNodeResultFormatterPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\Plugin\Elasticsearch\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\Search\Plugin\Elasticsearch\QueryExpander\StoreQueryExpanderPlugin;

class ContentfulPageSearchDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_QUERY_PLUGIN = 'CONTENTFUL_SEARCH_QUERY_PLUGIN';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_BLOG_CATEGORY_QUERY_EXPANDER_PLUGINS = 'CONTENTFUL_SEARCH_BLOG_CATEGORY_QUERY_EXPANDER_PLUGINS';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_BLOG_TAG_QUERY_EXPANDER_PLUGINS = 'CONTENTFUL_SEARCH_BLOG_TAG_QUERY_EXPANDER_PLUGINS';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_EXPANDER_PLUGINS = 'CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_EXPANDER_PLUGINS';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS = 'CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_BLOG_TAG_RESULT_FORMATTER_PLUGINS = 'CONTENTFUL_SEARCH_BLOG_TAG_RESULT_FORMATTER_PLUGINS';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_FORMATTER_PLUGINS = 'CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_FORMATTER_PLUGINS';

    /**
     * @var string
     */
    public const PROVIDE_BLOG_CATEGORY_DEPENDENCIES = 'PROVIDE_BLOG_CATEGORY_DEPENDENCIES';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addContentfulSearchQueryPlugin($container);
        $container = $this->addContentfulSearchBlogCategoryQueryExpanderPlugins($container);
        $container = $this->addContentfulSearchBlogCategoryFormatterPlugins($container);
        $container = $this->addContentfulSearchBlogTagQueryExpanderPlugins($container);
        $container = $this->addContentfulSearchBlogTagFormatterPlugins($container);
        $container = $this->addContentfulSearchCategoryNodeQueryExpanderPlugins($container);
        $container = $this->addContentfulCategoryNodeFormatterPlugins($container);
        $container = $this->addSearchClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSearchClient(Container $container): Container
    {
        $container[static::CLIENT_SEARCH] = function (Container $container) {
            return $container->getLocator()->search()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchQueryPlugin(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_QUERY_PLUGIN] = function (Container $container) {
            return $this->createContentfulSearchQueryPlugin();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\ContentfulSearchQueryPlugin
     */
    protected function createContentfulSearchQueryPlugin(): ContentfulSearchQueryPlugin
    {
        return new ContentfulSearchQueryPlugin();
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchBlogCategoryQueryExpanderPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_BLOG_CATEGORY_QUERY_EXPANDER_PLUGINS] = function () {
            return $this->createContentfulBlogCategorySearchQueryExpanderPlugins();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchBlogTagQueryExpanderPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_BLOG_TAG_QUERY_EXPANDER_PLUGINS] = function () {
            return $this->createContentfulBlogTagSearchQueryExpanderPlugins();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchCategoryNodeQueryExpanderPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_EXPANDER_PLUGINS] = function () {
            return $this->createContentfulSearchCategoryNodeQueryExpanderPlugins();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchBlogCategoryFormatterPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS] = function () {
            return $this->createContentfulSearchBlogCategoryResultFormatter();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchBlogTagFormatterPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_BLOG_TAG_RESULT_FORMATTER_PLUGINS] = function () {
            return $this->createContentfulSearchBlogTagResultFormatter();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulCategoryNodeFormatterPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_CATEGORY_NODE_QUERY_FORMATTER_PLUGINS] = function () {
            return $this->createContentfulSearchCategoryNodeResultFormatter();
        };

        return $container;
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createContentfulBlogCategorySearchQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new BlogPostQueryExpander(),
            new BlogCategoryQueryExpander(),
            new BlogSortQueryExpander(),
            new BlogPaginatedQueryExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createContentfulBlogTagSearchQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new BlogPostQueryExpander(),
            new BlogTagQueryExpander(),
            new BlogPaginatedQueryExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createContentfulSearchCategoryNodeQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new CategoryNodeQueryExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function createContentfulSearchBlogCategoryResultFormatter(): array
    {
        return [
            new BlogPaginatedResultFormatterPlugin(),
            new BlogPostResultFormatterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function createContentfulSearchBlogTagResultFormatter(): array
    {
        return [
            new BlogPaginatedResultFormatterPlugin(),
            new BlogPostResultFormatterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function createContentfulSearchCategoryNodeResultFormatter(): array
    {
        return [
            new CategoryNodeResultFormatterPlugin(),
        ];
    }
}
