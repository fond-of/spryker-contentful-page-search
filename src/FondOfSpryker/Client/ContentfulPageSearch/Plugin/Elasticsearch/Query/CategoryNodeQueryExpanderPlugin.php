<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchFactory getFactory();
 */
class CategoryNodeQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
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
        $boolQuery = $this->getBoolQuery($searchQuery->getSearchQuery());

        /** @var \Elastica\Query\MatchQuery $matchQuery */
        $matchQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery();

        $matchQuery->setField('category_id', $requestParameters[ContentfulConstants::FIELD_ID_CATEGORY]);

        $boolQuery->addMust($matchQuery);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @return void
     */
    protected function addCategoryTypeFilter(Query $query): void
    {
        $boolQuery = $this->getBoolQuery($query);

        /** @var \Elastica\Query\MatchQuery $matchQuery */
        $matchQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery();

        $matchQuery->setField(ContentfulConstants::FIELD_TYPE, 'category');

        $boolQuery->addMust($matchQuery);
    }

    /**
     * @param \Elastica\Query $query
     * @param array $requestParameters
     *
     * @return void
     */
    protected function addCategoryIdFilter(Query $query, array $requestParameters): void
    {
        if (!array_key_exists(ContentfulConstants::FIELD_ID_CATEGORY, $requestParameters) || !is_int($requestParameters[ContentfulConstants::FIELD_ID_CATEGORY])) {
            return;
        }
        $boolQuery = $this->getBoolQuery($query);

        /** @var \Elastica\Query\MatchQuery $matchQuery */
        $matchQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery();

        $matchQuery->setField('category_id', $requestParameters[ContentfulConstants::FIELD_ID_CATEGORY]);

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
                get_class($boolQuery),
            ));
        }

        return $boolQuery;
    }
}
