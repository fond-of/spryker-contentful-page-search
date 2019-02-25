<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 */
class BlogPostPageMapPlugin extends AbstractContentfulTypeMapperPlugin implements ContentfulTypeMapperPluginInterface
{
    public const FIELD_CATEGORIES = 'categories';
    public const FIELD_TAGS = 'tags';
    public const FIELD_HEADLINE = 'headline';
    public const FIELD_ID = 'id';

    public const FIELD_TYPE_REFERENCE = 'Reference';
    public const FIELD_TYPE_TEXT = 'Text';
    public const FIELD_TYPE_ASSET = 'Asset';

    public const SEARCH_FIELD_BLOG_CATEGORIES = 'blog_categories';
    public const SEARCH_FIELD_BLOG_TAGS = 'blog_tags';
    public const SEARCH_FIELD_HEADLINE = self::FIELD_HEADLINE;
    public const SEARCH_FIELD_ID = self::FIELD_ID;

    /**
     * @var string
     */
    private $entryTypeId = 'blogPost';

    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return $this->entryTypeId;
    }

    /**
     * @param int $idContetful
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function handle(
        int $idContentful,
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $data
    ): PageMapTransfer {
        $contentfulEntity = $this->getContentfulEntity($idContentful);
        $entryData = json_decode($contentfulEntity->getEntryData(), true);
        $mapper = $this->extractEntries($entryData);

        return $this->mapSearchResults($pageMapBuilder, $pageMapTransfer, $data, $mapper);
    }

    /**
     * @param array $entryData
     *
     * @return array
     */
    public function extractEntries(array $entryData): array
    {
        return [
            static::SEARCH_FIELD_BLOG_CATEGORIES => $this->extractReferenceField(static::FIELD_CATEGORIES, $entryData),
            static::SEARCH_FIELD_BLOG_TAGS => $this->extractReferenceField(static::FIELD_TAGS, $entryData),
        ];
    }

    /**
     * @param string $entryId
     *
     * @return string|null
     */
    protected function getRelatedItemEntryId(string $entryId): ?string
    {
        /** @var \Orm\Zed\Contentful\Persistence\FosContentful[] $storageEntries */
        $storageEntries = $this->getFactory()
            ->createContentfulQuery()
            ->filterByEntryId(strtolower($entryId));

        foreach ($storageEntries as $entry) {
            return $entry->getEntryId();
        }

        return null;
    }

    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $data
     * @param array $mapper
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    protected function mapSearchResults(PageMapBuilderInterface $pageMapBuilder, PageMapTransfer $pageMapTransfer, array $data, array $mapper): PageMapTransfer
    {
        $this->defaultMapSearchResults($pageMapBuilder, $pageMapTransfer, $data);

        if (array_key_exists(static::SEARCH_FIELD_BLOG_CATEGORIES, $mapper)) {
            $pageMapTransfer->setBlogCategories($mapper[static::SEARCH_FIELD_BLOG_CATEGORIES]);
        }

        if (array_key_exists(static::SEARCH_FIELD_BLOG_TAGS, $mapper)) {
            $pageMapTransfer->setBlogTags($mapper[static::SEARCH_FIELD_BLOG_TAGS]);
        }

        foreach ($mapper as $key => $item) {
            $pageMapBuilder->addSearchResultData($pageMapTransfer, $key, $item);
        }

        return $pageMapTransfer;
    }
}
