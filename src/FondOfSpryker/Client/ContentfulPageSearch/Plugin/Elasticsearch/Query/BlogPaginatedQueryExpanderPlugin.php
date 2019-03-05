<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\Query;

use Elastica\Query;
use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchFactory getFactory();
 */
class BlogPaginatedQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = [])
    {
        $this->addPaginationToQuery($searchQuery->getSearchQuery(), $requestParameters);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     * @param array $requestParameters
     *
     * @return void
     */
    protected function addPaginationToQuery(Query $query, array $requestParameters)
    {
        $config = $this->getFactory()->getContentfulPageSearchConfig();
        $currentPage = ($requestParameters[ContentfulPageSearchConstants::BLOG_BLOG_PAGINATION_PAGE_REQ_PARAM]) ?? 1;
        $itemsPerPage = $config->getBlogPaginationItemsPerPage();

        $query->setFrom(($currentPage - 1) * $config->getBlogPaginationItemsPerPage());
        $query->setSize($itemsPerPage);
    }
}
