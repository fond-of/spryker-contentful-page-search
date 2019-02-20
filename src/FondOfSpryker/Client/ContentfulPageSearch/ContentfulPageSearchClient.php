<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use Elastica\ResultSet;
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
     * @return \Elastica\ResultSet
     */
    public function contentfulSearch(string $searchString, array $requestParameters): ResultSet
    {
        $searchQuery = $this
            ->getFactory()
            ->createContentfulSearchQuery($searchString);

        $searchQuery = $this
            ->getFactory()
            ->getSearchClient()
            ->expandQuery($searchQuery, $this->getFactory()->getContentfulSearchQueryExpanderPlugins(), $requestParameters);

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, [], $requestParameters);
    }
}
