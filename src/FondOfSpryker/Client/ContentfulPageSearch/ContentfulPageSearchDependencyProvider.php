<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\BlogCategoryQueryExpander;
use FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query\ContentfulSearchQueryPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\Plugin\Elasticsearch\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\Search\Plugin\Elasticsearch\QueryExpander\StoreQueryExpanderPlugin;

class ContentfulPageSearchDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    public const CONTENTFUL_SEARCH_QUERY_PLUGIN = 'CONTENTFUL_SEARCH_QUERY_PLUGIN';

    public const CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS = 'CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS';

    /**
     * @return void
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addContentfulSearchQueryPlugin($container);
        $container = $this->addContentfulSearchQueryExpanderPlugins($container);
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
    protected function addContentfulSearchQueryExpanderPlugins(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS] = function () {
            return $this->createContentfulSearchQueryExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return array
     */
    protected function createContentfulSearchQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new BlogCategoryQueryExpander(),
        ];
    }
}
