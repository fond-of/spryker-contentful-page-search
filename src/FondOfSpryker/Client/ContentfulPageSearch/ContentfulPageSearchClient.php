<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchFactory getFactory()
 */
class ContentfulPageSearchClient extends AbstractClient implements ContentfulPageSearchClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet|array
     */
    public function contentfulBlogCategorySearch(string $searchString, array $requestParameters)
    {
        $searchQuery = $this
            ->getFactory()
            ->createContentfulSearchQuery($searchString);

        $searchQuery = $this
            ->getFactory()
            ->getSearchClient()
            ->expandQuery($searchQuery, $this->getFactory()->getContentfulSearchBlogCategoryQueryExpanderPlugins(), $requestParameters);

        $resultFormatters = $this
            ->getFactory()
            ->getContentfulSearchBlogCategoryFormatterPlugins();

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, $resultFormatters, $requestParameters);
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet|array
     */
    public function contentfulBlogTagSearch(string $searchString, array $requestParameters)
    {
        $searchQuery = $this
            ->getFactory()
            ->createContentfulSearchQuery($searchString);

        $searchQuery = $this
            ->getFactory()
            ->getSearchClient()
            ->expandQuery($searchQuery, $this->getFactory()->getContentfulSearchBlogTagQueryExpanderPlugins(), $requestParameters);

        $resultFormatters = $this
            ->getFactory()
            ->getContentfulSearchBlogTagFormatterPlugins();

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, $resultFormatters, $requestParameters);
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet|array
     */
    public function contentfulCategoryNodeSearch(string $searchString, array $requestParameters)
    {
        $searchQuery = $this
            ->getFactory()
            ->createContentfulSearchQuery($searchString);

        $searchQuery = $this
            ->getFactory()
            ->getSearchClient()
            ->expandQuery($searchQuery, $this->getFactory()->getContentfulSearchCategoryNodeQueryExpanderPlugins(), $requestParameters);

        $resultFormatter = $this
            ->getFactory()
            ->getContentfulSearchCategoryNodeFormatterPlugins();

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, $resultFormatter, $requestParameters);
    }
}
