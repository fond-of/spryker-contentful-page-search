<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Persistence;

use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * Class ContentfulPageSearchQueryContainer
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Persistence
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchPersistenceFactory getFactory()
 */
class ContentfulPageSearchQueryContainer extends AbstractQueryContainer implements ContentfulPageSearchQueryContainerInterface
{
    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulPageSearchByIds(array $contentfulEntryIds): FosContentfulPageSearchQuery
    {
        return $this->getFactory()
            ->createFobContentfulPageSearchQuery()
            ->filterByFkContentful_In($contentfulEntryIds);
    }
}
