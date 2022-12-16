<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search\BlogPostPageMapPlugin;
use FondOfSpryker\Zed\ContentfulPageSearch\ContentfulPageSearchDependencyProvider;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulSearchPageToEventBehaviorFacadeInterface;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchQueryContainer getQueryContainer()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacadeInterface getFacade()
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

    /**
     * @return array<\FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search\ContentfulTypeMapperPluginInterface>
     */
    public function getContentfulPageSeachMapperTypes(): array
    {
        return [
            new BlogPostPageMapPlugin(
                $this->getStructureValidatorCollection(),
            ),
        ];
    }

    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    public function getContentfulQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface
     */
    public function getStructureValidatorCollection(): StructureValidatorCollectionInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::COLLECTION_STRUCTURE_VALIDATOR);
    }
}
