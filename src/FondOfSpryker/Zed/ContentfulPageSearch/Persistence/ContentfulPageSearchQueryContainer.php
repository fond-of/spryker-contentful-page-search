<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Persistence;

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
    public function queryContentfulEntriesByIds(array $contentfulEntryIds): ?array
    {
        return $this->getFactory()->getContentfulEntryQueryContainer()->queryContentfulEntryByIds($contentfulEntryIds);
    }
}
