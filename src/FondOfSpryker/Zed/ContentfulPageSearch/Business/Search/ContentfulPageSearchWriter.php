<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Search;

use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\Base\FosContentfulPageSearch;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;

class ContentfulPageSearchWriter implements ContentfulPageSearchWriterInterface
{
    /**
     * @var \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery
     */
    protected $contentfulPageSearchQuery;

    /**
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $contentfulQuery;

    /**
     * ContentfulPageSearchWriter constructor.
     *
     * @param \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery $contentfulPageSearchQuery
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     */
    public function __construct(
        FosContentfulQuery $contentfulQuery,
        FosContentfulPageSearchQuery $contentfulPageSearchQuery
    ) {
        $this->contentfulQuery = $contentfulQuery;
        $this->contentfulPageSearchQuery = $contentfulPageSearchQuery;
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function publish(array $contentfulEntryIds): void
    {
        $this->contentfulPageSearchQuery->clear();

        /** @var \Orm\Zed\Contentful\Persistence\FosContentful[] $contentfulEntries */
        $contentfulEntries = $this->contentfulQuery
            ->filterByIdContentful_In($contentfulEntryIds);

        /** @var \Orm\Zed\Contentful\Persistence\FosContentful $entry */
        foreach ($contentfulEntries as $entry) {
            $this->store($entry->getPrimaryKey());
        }
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function unpublish(array $contentfulEntryIds): void
    {
    }

    /**
     * @param int $contentfulId
     *
     * @return void
     */
    protected function store(int $contentfulId): void
    {
        $entity = $this->getContentfulPageSearchEntity($contentfulId);
        $entity->setFkContentful($contentfulId);
        $entity->setData('');
        $entity->setStructuredData('');
        $entity->save();
    }

    /**
     * @param int $contentfulId
     *
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\Base\FosContentfulPageSearch
     */
    protected function getContentfulPageSearchEntity(int $contentfulId): FosContentfulPageSearch
    {
        $this->contentfulPageSearchQuery->clear();

        return $this->contentfulPageSearchQuery
            ->filterByFkContentful($contentfulId)
            ->findOneOrCreate();
    }
}
