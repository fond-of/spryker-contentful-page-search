<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

use Elastica\ResultSet;

interface ContentfulPageSearchClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet
     */
    public function contentfulSearch(string $searchString, array $requestParameters): ResultSet;
}
