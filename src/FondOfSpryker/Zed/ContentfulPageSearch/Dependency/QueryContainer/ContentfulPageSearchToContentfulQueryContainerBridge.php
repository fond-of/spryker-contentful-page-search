<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\QueryContainer;

use FondOfSpryker\Zed\Contentful\Persistence\ContentfulQueryContainerInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;

class ContentfulPageSearchToContentfulQueryContainerBridge implements ContentfulPageSearchToContentfulQueryContainerInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Persistence\ContentfulQueryContainerInterface
     */
    protected $contentfulEntryQueryContainer;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Persistence\ContentfulQueryContainerInterface $queryContainer
     */
    public function __construct(ContentfulQueryContainerInterface $queryContainer)
    {
        $this->contentfulEntryQueryContainer = $queryContainer;
    }

    /**
     * @param string $contentfulEntryId
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful|null
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId): ?FosContentful
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
