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
     * @return array|\Elastica\ResultSet
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
}
