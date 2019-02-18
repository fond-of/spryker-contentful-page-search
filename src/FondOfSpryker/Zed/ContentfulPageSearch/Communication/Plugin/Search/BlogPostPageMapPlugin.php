<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 */
class BlogPostPageMapPlugin extends AbstractContentfulTypeMapperPlugin implements ContentfulTypeMapperPluginInterface
{
    public const FIELD_ITEMS = 'categories';

    public const FIELD_ITEMS_TYPE = 'Reference';

    public const SEARCH_NAME_FIELD = 'blog_categories';

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
     * @param int $idContentful
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     *
     * @return array
     */
    public function handle(int $idContentful, PageMapBuilderInterface $pageMapBuilder): array
    {
        $contentfulEntity = $this->getContentfulEntity($idContentful);
        $entryData = json_decode($contentfulEntity->getEntryData(), true);

        return $this->extractEntries($entryData);
    }

    /**
     * @param array $entryData
     *
     * @return array
     */
    public function extractEntries(array $entryData): array
    {
        return [
            static::SEARCH_NAME_FIELD => $this->extractFieldItemsReference($entryData),
        ];
    }

    /**
     * @param array $entryData
     *
     * @return array
     */
    protected function extractFieldItemsReference(array $entryData): array
    {
        $items = [];

        foreach ($entryData['fields'][static::FIELD_ITEMS]['value'] as $field) {
            if ($field['type'] === static::FIELD_ITEMS_TYPE) {
                array_push($items, $this->getRelatedItemEntryId($field['value']));
            }
        }

        return $items;
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
}
