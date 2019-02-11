<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication;

use FondOfSpryker\Zed\ContentfulPageSearch\ContentfulPageSearchDependencyProvider;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulSearchPageToEventBehaviorFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchQueryContainer getQueryContainer()
 */
class ContentfulPageSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulSearchPageToEventBehaviorFacadeInterface
     */
    public function getEventBehaviourFacade(): ContentfulSearchPageToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }
}
