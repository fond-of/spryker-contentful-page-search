<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

/**
 * Class BlogCategoryQueryExpander
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchFactory getFactory()
 */
class BlogSortQueryExpander extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @api
     *
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        $this->addSort($searchQuery->getSearchQuery());

        return $searchQuery;
    }

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @return \Elastica\Query
     */
    protected function addSort(Query $query): Query
    {
        return $query->addSort(
            [
                PageIndexMap::STRING_SORT . '.' . PageIndexMap::BLOG_POST_PUBLISHED_AT => [
                    'order' => 'DESC',
                    'mode' => 'min',
                ],
            ]
        );
    }
}
