<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter;

use Elastica\ResultSet;
use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

class BlogPostResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
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
            $source = $result->getSource();
            if (array_key_exists(PageIndexMap::SEARCH_RESULT_DATA, $source)) {
                $results[] = $source[PageIndexMap::SEARCH_RESULT_DATA];
            }
        }

        return $results;
    }
}
