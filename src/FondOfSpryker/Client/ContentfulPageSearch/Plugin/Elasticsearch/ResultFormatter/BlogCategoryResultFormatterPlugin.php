<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter;

use Elastica\ResultSet;
use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

class BlogCategoryResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
{
    private const NAME = 'results';

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array $requestParameters
     *
     * @return array
     */
    protected function formatSearchResult(ResultSet $searchResult, array $requestParameters): array
    {
        $results = [];

        foreach ($searchResult->getResults() as $result) {
            $results[] = $result->getSource()[PageIndexMap::SEARCH_RESULT_DATA];
        }

        return $results;
    }
}
