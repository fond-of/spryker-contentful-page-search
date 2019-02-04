<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer;

use ContentfulPageSearchToContentfulEntryQueryContainerInterface;
use FondOfSpryker\Zed\Contentful\Persistence\ContentfulEntryQueryContainerInterface;
use Orm\Zed\ContentfulPage\Persistence\FosContentfulEntry;

class ContentfulPageSearchToContentfulEntryQueryContainerBridge implements ContentfulPageSearchToContentfulEntryQueryContainerInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Persistence\ContentfulEntryQueryContainerInterface
     */
    protected $contentfulEntryQueryContainer;

    /**
     * ContentfulPageSearchToContentfulEntryQueryContainerBridge constructor.
     * @param \FondOfSpryker\Zed\Contentful\Persistence\ContentfulEntryQueryContainerInterface $queryContainer
     */
    public function __construct(ContentfulEntryQueryContainerInterface $queryContainer)
    {
        $this->contentfulEntryQueryContainer = $queryContainer;
    }

    /**
     * @param string $contentfulEntryId
     *
     * @return \Orm\Zed\ContentfulPage\Persistence\FosContentfulEntry|null
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId): ?FosContentfulEntryy
    {
        return $this->contentfulEntryQueryContainer->queryContentfulEntryByEntryId($contentfulEntryId);
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntryByIds(array $contentfulEntryIds): ?array
    {
        return $this->contentfulEntryQueryContainer->queryContentfulEntryByIds($contentfulEntryIds);
    }
}
