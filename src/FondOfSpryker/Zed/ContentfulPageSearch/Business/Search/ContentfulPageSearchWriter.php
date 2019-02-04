<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

use Exception;

class ContentfulPageSearchWriter implements ContentfulPageSearchWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * ContentfulPageSearchWriter constructor.
     *
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchQueryContainerInterface $queryContainer
     */
    public function __construct(
        ContentfulPageSearchQueryContainerInterface $queryContainer
    ) {
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @throws \Exception
     *
     * @return void
     */
    public function publish(array $contentfulEntryIds): void
    {
        $contentfulEntryEntities = $this->findContentfulEntryEntities($contentfulEntryIds);
        
        throw new Exception('PUBLISH');
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function unpublish(array $contentfulEntryIds): void
    {
        // TODO: Implement unpublish() method.
    }

    /**
     * @param array $idCollection
     *
     * @return array
     */
    protected function findContentfulEntryEntities(array $contentfulEntryIds): array
    {
        return $this->queryContainer->queryContentfulEntriesByIds($contentfulEntryIds);
    }

    /**
     * @param array $contentfulEntryEntities
     *
     * @return void
     */
    protected function storeData(array $contentfulEntryEntities): void
    {
    }
}
