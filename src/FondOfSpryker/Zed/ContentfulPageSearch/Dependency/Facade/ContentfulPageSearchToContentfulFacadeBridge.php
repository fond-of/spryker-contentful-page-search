<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade;

use FondOfSpryker\Zed\Contentful\Business\ContentfulFacadeInterface;

class ContentfulPageSearchToContentfulFacadeBridge implements ContentfulPageSearchToContentfulFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\ContentfulFacadeInterface
     */
    protected $contentfulFacade;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\ContentfulFacadeInterface $contentfulFacade
     */
    public function __construct(ContentfulFacadeInterface $contentfulFacade)
    {
        $this->contentfulFacade = $contentfulFacade;
    }

    /**
     * @return int
     */
    public function getContentfulEntryCount(): int
    {
        return $this->contentfulFacade->getContentfulEntryCount();
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return mixed
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null)
    {
        return $this->contentfulFacade->getContentfulEntries($limit, $offset);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array
    {
        return $this->contentfulFacade->getContentfulEntryIds($limit, $offset);
    }
}
