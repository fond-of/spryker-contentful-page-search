<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 */
abstract class AbstractContentfulTypeMapperPlugin extends AbstractPlugin
{
    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return $this->entryTypeId;
    }

    /**
     * @param int $contentfulId
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful
     */
    protected function getContentfulEntity(int $contentfulId): FosContentful
    {
        $contentfulQuery = $this->getFactory()->createContentfulQuery();
        $contentfulQuery->clear();

        return $contentfulQuery
            ->filterByIdContentful($contentfulId)
            ->findOne();
    }

    /**
     * @param int $contentfulId
     *
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\Base\FosContentfulPageSearch
     */
    protected function getContentfulPageSearchEntity(int $contentfulId): FosContentfulPageSearch
    {
        $contentfulPageSearchQuery = $this->getFactory()->createContentfulPageSearchQuery();
        $contentfulPageSearchQuery->clear();

        return $this->contentfulPageSearchQuery
            ->filterByFkContentful($contentfulId)
            ->findOneOrCreate();
    }
}
