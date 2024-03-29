<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter;

use Elastica\ResultSet;
use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

class CategoryNodeResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
{
    /**
     * @var string
     */
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
