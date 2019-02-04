<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch;

use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulSearchPageToEventBehaviorFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer\ContentfulPageSearchToContentfulEntryQueryContainerBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ContentfulPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    public const QUERY_CONTAINER_CONTENTFUL_ENTRY = 'QUERY_CONTAINER_CONTENTFUL_ENTRY';

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
}
