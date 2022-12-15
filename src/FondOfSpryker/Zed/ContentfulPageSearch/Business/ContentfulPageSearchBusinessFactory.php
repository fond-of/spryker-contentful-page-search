<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriter;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin\BlogPostWriterPlugin;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\ContentfulPageSearchDependencyProvider;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStoreFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * Class ContentfulSearchPageBusinessFactory
 *
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Business
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchQueryContainer getQueryContainer()
 */
class ContentfulPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriter
     */
    public function createContentfulPageSearchWriter(): ContentfulPageSearchWriter
    {
        return new ContentfulPageSearchWriter(
            $this->getContentfulQuery(),
            $this->getFosContentfulPageSearchQuery(),
            $this->getSearchFacade(),
            $this->getStorageFacade(),
            $this->getUtilEncodingService(),
            $this->getStoreFacade(),
            $this->getStructureValidatorCollection(),
            $this->getContentfulPageSearchWriterPlugins(),
        );
    }

    /**
     * @return array<\FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriterPluginInterface>
     */
    public function getContentfulPageSearchWriterPlugins(): array
    {
        return [
            $this->createBlogPostWriterPlugin(),
        ];
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin\BlogPostWriterPlugin
     */
    protected function createBlogPostWriterPlugin(): BlogPostWriterPlugin
    {
        return new BlogPostWriterPlugin(
            $this->getStorageFacade(),
            $this->getSearchFacade(),
            $this->getContentfulQuery(),
        );
    }

    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected function getContentfulQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }

    /**
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery
     */
    protected function getFosContentfulPageSearchQuery(): FosContentfulPageSearchQuery
    {
        return FosContentfulPageSearchQuery::create();
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface
     */
    public function getSearchFacade(): ContentfulPageSearchToSearchFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::FACADE_SEARCH);
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface
     */
    public function getUtilEncodingService(): ContentfulPageSearchToUtilEncodingInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface
     */
    public function getStorageFacade(): ContentfulPageSearchToStorageFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::FACADE_STORAGE);
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStoreFacadeInterface
     */
    public function getStoreFacade(): ContentfulPageSearchToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface|\FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToContentfulFacadeInterface
     */
    public function getStructureValidatorCollection(): StructureValidatorCollectionInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::COLLECTION_STRUCTURE_VALIDATOR);
    }
}
