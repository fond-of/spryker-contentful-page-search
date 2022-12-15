<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface;
use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 */
class BlogPostPageMapPlugin extends AbstractContentfulTypeMapperPlugin implements ContentfulTypeMapperPluginInterface
{
    /**
     * @var string
     */
    public const FIELD_CATEGORIES = 'categories';

    /**
     * @var string
     */
    public const FIELD_TAGS = 'tags';

    /**
     * @var string
     */
    public const FIELD_PUBLISH_AT = 'publishedAt';

    /**
     * @var string
     */
    public const FIELDS = 'fields';

    /**
     * @var string
     */
    public const FIELD_ENTRY_DATA = 'entry_data';

    /**
     * @var string
     */
    public const ENTRY_TYPE_ID_VALUE = 'blogPost';

    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface
     */
    private $structureValidatorCollection;

    /**
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\StructureValidatorCollectionInterface $structureValidatorCollection
     */
    public function __construct(StructureValidatorCollectionInterface $structureValidatorCollection)
    {
        $this->structureValidatorCollection = $structureValidatorCollection;
    }

    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return self::ENTRY_TYPE_ID_VALUE;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function isValidStructure(array $data): bool
    {
        $validator = $this->structureValidatorCollection->get($this->getEntryTypeId());

        return $validator->validate($data[self::FIELD_ENTRY_DATA]);
    }

    /**
     * @param int $idContentful
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
            PageIndexMap::BLOG_CATEGORIES => $this->extractReferenceField(static::FIELD_CATEGORIES, $entryData),
            PageIndexMap::BLOG_TAGS => $this->extractReferenceField(static::FIELD_TAGS, $entryData),
            PageIndexMap::BLOG_POST_PUBLISHED_AT => $entryData[self::FIELDS][static::FIELD_PUBLISH_AT]['value'],
        ];
    }

    /**
     * @param string $entryId
     *
     * @return string|null
     */
    protected function getRelatedItemEntryId(string $entryId): ?string
    {
        /** @var array<\Orm\Zed\Contentful\Persistence\FosContentful> $storageEntries */
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

        if (array_key_exists(PageIndexMap::BLOG_CATEGORIES, $mapper)) {
            $pageMapTransfer->setBlogCategories($mapper[PageIndexMap::BLOG_CATEGORIES]);
        }

        if (array_key_exists(PageIndexMap::BLOG_TAGS, $mapper)) {
            $pageMapTransfer->setBlogTags($mapper[PageIndexMap::BLOG_TAGS]);
        }

        if (array_key_exists(PageIndexMap::BLOG_POST_PUBLISHED_AT, $mapper)) {
            $pageMapTransfer->setBlogPostPublishedAt($mapper[PageIndexMap::BLOG_POST_PUBLISHED_AT]);
            $pageMapBuilder->addStringSort(
                $pageMapTransfer,
                PageIndexMap::BLOG_POST_PUBLISHED_AT,
                $mapper[PageIndexMap::BLOG_POST_PUBLISHED_AT],
            );
        }

        foreach ($mapper as $key => $item) {
            $pageMapBuilder->addSearchResultData($pageMapTransfer, $key, $item);
        }

        return $pageMapTransfer;
    }
}
