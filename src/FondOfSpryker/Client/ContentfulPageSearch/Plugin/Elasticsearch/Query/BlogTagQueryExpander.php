<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

/**
 * Class BlogCategoryQueryExpander
 *
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchFactory getFactory()
 */
class BlogTagQueryExpander extends AbstractPlugin implements QueryExpanderPluginInterface
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
        if (!array_key_exists(ContentfulConstants::FIELD_BLOG_TAGS, $requestParameters)) {
            return $searchQuery;
        }

        if (!array_key_exists(ContentfulConstants::FIELD_ENTRY_ID, $requestParameters)) {
            return $searchQuery;
        }

        $this->addBlogTagFilter(
            $searchQuery->getSearchQuery(),
            $requestParameters[ContentfulConstants::FIELD_ENTRY_ID]
        );

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     * @param string $entryId
     *
     * @return void
     */
    protected function addBlogTagFilter(Query $query, string $entryId): void
    {
        $boolQuery = $this->getBoolQuery($query);

        $matchQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(ContentfulConstants::FIELD_BLOG_TAGS, strtolower($entryId));

        $boolQuery->addMust($matchQuery);
    }

    /**
     * @param \Elastica\Query $query
     *
     * @throws \InvalidArgumentException
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function getBoolQuery(Query $query): BoolQuery
    {
        $boolQuery = $query->getQuery();
        if (!$boolQuery instanceof BoolQuery) {
            throw new InvalidArgumentException(sprintf(
                'Localized query expander available only with %s, got: %s',
                BoolQuery::class,
                get_class($boolQuery)
            ));
        }

        return $boolQuery;
    }
}
