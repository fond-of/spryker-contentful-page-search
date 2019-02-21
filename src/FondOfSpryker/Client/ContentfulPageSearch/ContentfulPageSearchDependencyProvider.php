<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\BlogCategoryQueryExpander;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\ContentfulSearchQueryPlugin;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter\BlogCategoryResultFormatterPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\Plugin\Elasticsearch\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\Search\Plugin\Elasticsearch\QueryExpander\StoreQueryExpanderPlugin;
use Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\PaginatedResultFormatterPlugin;

class ContentfulPageSearchDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    public const CONTENTFUL_SEARCH_QUERY_PLUGIN = 'CONTENTFUL_SEARCH_QUERY_PLUGIN';

    public const CONTENTFUL_SEARCH_BLOG_CATEGORY_QUERY_EXPANDER_PLUGINS = 'CONTENTFUL_SEARCH_BLOG_CATEGORY_QUERY_EXPANDER_PLUGINS';

    public const CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS = 'CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS';

    public const PROVIDE_BLOG_CATEGORY_DEPENDENCIES = 'PROVIDE_BLOG_CATEGORY_DEPENDENCIES';

    /**
     * @return void
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addContentfulSearchQueryPlugin($container);
        $container = $this->addContentfulSearchBlogCategoryQueryExpanderPlugins($container);
        $container = $this->addContentfulSearchBlogCategoryFormatterPlugins($container);
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
     * @return \FondOfSpryker\Client\Contentful\Plugin\Elasticsearch\Query\ContentfulSearchQueryPlugin
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
    protected function addContentfulSearchBlogCategoryFormatterPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_BLOG_CATEGORY_RESULT_FORMATTER_PLUGINS] = function () {
            return $this->createContentfulSearchBlogCategoryResultFormatter();
        };

        return $container;
    }

    /**
     * @return array
     */
    protected function createContentfulBlogCategorySearchQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new BlogCategoryQueryExpander(),
        ];
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface[]
     */
    protected function createContentfulSearchBlogCategoryResultFormatter(): array
    {
        return [
            new PaginatedResultFormatterPlugin(),
            new BlogCategoryResultFormatterPlugin(),
        ];
    }
}