<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriter;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\Plugin\BlogPostWriterPlugin;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\BlogPostStructureValidator;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollection;
use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\ContentfulPageSearchDependencyProvider;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToContentfulFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToSearchFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStorageFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToStoreFacadeInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Service\ContentfulPageSearchToUtilEncodingInterface;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * Class ContentfulSearchPageBusinessFactory
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Business
 * @method ContentfulSearchPageQu
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
            $this->createContentfulQuery(),
            $this->createFosContentfulPageSearchQuery(),
            $this->getSearchFacade(),
            $this->getStorageFacade(),
            $this->getUtilEncodingService(),
            $this->getStoreFacade(),
            $this->getStructureValidatorCollection(),
            $this->getContentfulPageSearchWriterPlugins()
        );
    }

    /**
     * @return FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriterPluginInterface[]
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
            $this->createContentfulQuery()
        );
    }

    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected function createContentfulQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }

    /**
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery
     */
    protected function createFosContentfulPageSearchQuery(): FosContentfulPageSearchQuery
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
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade\ContentfulPageSearchToContentfulFacadeInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getStructureValidatorCollection(): StructureValidatorCollectionInterface
    {
        return $this->getProvidedDependency(ContentfulPageSearchDependencyProvider::COLLECTION_STRUCTURE_VALIDATOR);
    }

}
