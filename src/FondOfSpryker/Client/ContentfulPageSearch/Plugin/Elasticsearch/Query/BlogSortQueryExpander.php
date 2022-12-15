<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query;

use Elastica\Query;
use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * Class BlogCategoryQueryExpander
 *
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchFactory getFactory()
 */
class BlogSortQueryExpander extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @api
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        $this->addSort($searchQuery->getSearchQuery());

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
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
            ],
        );
    }
}
