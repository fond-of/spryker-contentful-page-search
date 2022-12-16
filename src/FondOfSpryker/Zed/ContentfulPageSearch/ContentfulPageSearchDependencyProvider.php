<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\BlogPostStructureValidator;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollection;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToContentfulFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStoreFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulSearchPageToEventBehaviorFacadeBridge;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ContentfulPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const FACADE_SEARCH = 'FACADE_SEARCH';

    /**
     * @var string
     */
    public const FACADE_STORAGE = 'FACADE_STORAGE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const FACADE_CONTENTFUL = 'FACADE_CONTENTFUL';

    /**
     * @var string
     */
    public const COLLECTION_STRUCTURE_VALIDATOR = 'COLLECTION_STRUCTURE_VALIDATOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addEventBehaviourFacade($container);
        $container = $this->addStorageFacade($container);
        $container = $this->addContentfulFacade($container);
        $container = $this->addStructureValidatorCollection($container);

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
        $container = $this->addStorageFacade($container);
        $container = $this->addUtilEncodingService($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addStructureValidatorCollection($container);

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
    protected function addStorageFacade(Container $container): Container
    {
        $container[static::FACADE_STORAGE] = function (Container $container) {
            return new ContentfulPageSearchToStorageFacadeBridge(
                $container->getLocator()->storage()->facade(),
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
                $container->getLocator()->search()->facade(),
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
                $container->getLocator()->utilEncoding()->service(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = function (Container $container) {
            return new ContentfulPageSearchToStoreFacadeBridge(
                $container->getLocator()->store()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addContentfulFacade(Container $container): Container
    {
        $container[static::FACADE_CONTENTFUL] = function (Container $container) {
            return new ContentfulPageSearchToContentfulFacadeBridge(
                $container->getLocator()->contentful()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addStructureValidatorCollection(Container $container): Container
    {
        $container[self::COLLECTION_STRUCTURE_VALIDATOR] = function (Container $container): StructureValidatorCollectionInterface {
            $collection = new StructureValidatorCollection();

            $collection->add(new BlogPostStructureValidator());

            return $collection;
        };

        return $container;
    }
}
