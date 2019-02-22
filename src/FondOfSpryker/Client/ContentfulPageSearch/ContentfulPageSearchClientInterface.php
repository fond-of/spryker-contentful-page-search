<?php

namespace FondOfSpryker\Client\ContentfulPageSearch;

interface ContentfulPageSearchClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array|\Elastica\ResultSet
     */
    public function contentfulBlogCategorySearch(string $searchString, array $requestParameters);

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array|\Elastica\ResultSet
     */
    public function contentfulBlogTagSearch(string $searchString, array $requestParameters);
}
