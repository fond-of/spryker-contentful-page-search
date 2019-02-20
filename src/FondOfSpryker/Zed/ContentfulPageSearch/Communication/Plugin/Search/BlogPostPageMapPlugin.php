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
    public const FIELD_SUMMARY = 'summary';
    public const FIELD_HEADLINE = 'headline';
    public const FIELD_IMAGE = 'image';
    public const FIELD_IDENTIFIER = 'identifier';
    public const FIELD_PUBLISH_AT = 'publishedAt';

    public const FIELD_TYPE_REFERENCE = 'Reference';
    public const FIELD_TYPE_TEXT = 'Text';
    public const FIELD_TYPE_ASSET = 'Asset';

    public const SEARCH_FIELD_BLOG_CATEGORIES = 'blog_categories';
    public const SEARCH_FIELD_SUMMARY = self::FIELD_SUMMARY;
    public const SEARCH_FIELD_HEADLINE = self::FIELD_HEADLINE;
    public const SEARCH_FIELD_IMAGE = self::FIELD_IMAGE;
    public const SEARCH_FIELD_IDENTIFIER = self::FIELD_IDENTIFIER;
    public const SEARCH_FIELD_PUBLISH_AT = self::FIELD_PUBLISH_AT;

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
            static::SEARCH_FIELD_BLOG_CATEGORIES => $this->extractFieldCategoriesReference($entryData),
            static::SEARCH_FIELD_SUMMARY => $this->extractFieldSummary($entryData),
            static::SEARCH_FIELD_HEADLINE => $this->extractFieldHeadline($entryData),
            static::SEARCH_FIELD_IMAGE => $this->extractFieldImage($entryData),
            static::SEARCH_FIELD_IDENTIFIER => $this->extractFieldIdentifier($entryData),
            static::SEARCH_FIELD_PUBLISH_AT => $this->extractFieldPublishAt($entryData),
        ];
    }

    /**
     * @param array $entryData
     *
     * @return array
     */
    protected function extractFieldCategoriesReference(array $entryData): array
    {
        $items = [];

        foreach ($entryData['fields'][static::FIELD_CATEGORIES]['value'] as $field) {
            if ($field['type'] === static::FIELD_TYPE_REFERENCE) {
                array_push($items, $this->getRelatedItemEntryId($field['value']));
            }
        }

        return $items;
    }

    /**
     * @param array $entryData
     *
     * @return string
     */
    protected function extractFieldSummary(array $entryData): string
    {
        return $entryData['fields'][static::FIELD_SUMMARY]['value'];
    }

    /**
     * @param array $entryData
     *
     * @return string
     */
    protected function extractFieldHeadline(array $entryData): string
    {
        return $entryData['fields'][static::FIELD_HEADLINE]['value'];
    }

    /**
     * @param array $entryData
     *
     * @return string
     */
    protected function extractFieldImage(array $entryData): string
    {
        return $entryData['fields'][static::FIELD_IMAGE]['value'];
    }

    /**
     * @param array $entryData
     *
     * @return string
     */
    protected function extractFieldPublishAt(array $entryData): string
    {
        return $entryData['fields'][static::FIELD_PUBLISH_AT]['value'];
    }

    /**
     * @param array $entryData
     *
     * @return string
     */
    protected function extractFieldIdentifier(array $entryData): string
    {
        return $entryData['fields'][static::FIELD_IDENTIFIER]['value'];
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

        foreach ($mapper as $key => $item) {
            $pageMapBuilder->addSearchResultData($pageMapTransfer, $key, $item);
        }

        return $pageMapTransfer;
    }
}
