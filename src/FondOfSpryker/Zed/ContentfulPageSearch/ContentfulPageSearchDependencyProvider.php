<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch;

use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulSearchPageToEventBehaviorFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer\ContentfulPageSearchToContentfulEntryQueryContainerBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ContentfulPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';
    public const FACADE_SEARCH = 'FACADE_SEARCH';
    public const QUERY_CONTAINER_CONTENTFUL_ENTRY = 'QUERY_CONTAINER_CONTENTFUL_ENTRY';
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addEventBehaviourFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = $this->addContentfulEntryQueryContainer();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addSearchFacade($container);
        $container = $this->addUtilEncodingService($container);
        
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviourFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT_BEHAVIOR] = function (Container $container) {
            return new ContentfulSearchPageToEventBehaviorFacadeBridge($container->getLocator()->eventBehavior()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addContentfulEntryQueryContainer(Container $container): Container
    {
        $container[static::QUERY_CONTAINER_CONTENTFUL_ENTRY] = function (Container $container) {
            return new ContentfulPageSearchToContentfulEntryQueryContainerBridge(
                $container->getLocator()->contentful()->queryContainer()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSearchFacade(Container $container): Container
    {
        $container[static::FACADE_SEARCH] = function (Container $container) {
            return new ContentfulPageSearchToSearchFacadeBridge(
                $container->getLocator()->search()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new ContentfulPageSearchToUtilEncodingBridge(
                $container->getLocator()->utilEncoding()->service()
            );
        };

        return $container;
    }
}
