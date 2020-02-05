<?php

namespace FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter;

use Elastica\ResultSet;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

/**
 * Class BlogPaginatedResultFormatterPlugin
 *
 * @package FondOfSpryker\Client\ContentfulPageSearch\Plugin\Elasticsearch\ResultFormatter
 * @method \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchFactory getFactory()
 */
class BlogPaginatedResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
{
    public const NAME = 'pagination';

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array $requestParameters
     *
     * @return \Generated\Shared\Transfer\PaginationSearchResultTransfer
     */
    protected function formatSearchResult(ResultSet $searchResult, array $requestParameters)
    {
        $paginationConfig = $this
            ->getFactory()
            ->getSearchConfig()
            ->getPaginationConfigBuilder();

        $config = $this
            ->getFactory()
            ->getContentfulPageSearchConfig();

        $itemsPerPage = $config->getBlogPaginationItemsPerPage();
        $maxPage = (int)ceil($searchResult->getTotalHits() / $itemsPerPage);
        $currentPage = min($paginationConfig->getCurrentPage($requestParameters), $maxPage);

        $paginationSearchResultTransfer = new PaginationSearchResultTransfer();
        $paginationSearchResultTransfer
            ->setNumFound($searchResult->getTotalHits())
            ->setCurrentPage($currentPage)
            ->setMaxPage($maxPage)
            ->setCurrentItemsPerPage($itemsPerPage)
            ->setConfig(clone $paginationConfig->get());

        return $paginationSearchResultTransfer;
    }
}
