<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 */
class SizeAdviserShoesGroupPageMapPlugin extends AbstractContentfulTypeMapperPlugin implements ContentfulTypeMapperPluginInterface
{
    public const FIELD_ITEMS = 'items';
    public const FIELD_ITEMS_TYPE = 'Reference';
    public const SEARCH_NAME_FIELD = 'contentfulSizes';

    /**
     * @var string
     */
    private $entryTypeId = 'sizeAdviserShoesGroup';

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
     * @return \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface
     */
    public function handle(int $idContentful, PageMapBuilderInterface $pageMapBuilder): PageMapBuilderInterface
    {
        $contentfulEntity = $this->getContentfulEntity($idContentful);
        $storageEntry = $this->getFactory()->getStorageFacade()->get($contentfulEntity->getStorageKey());

        $this->extractEntries($storageEntry);
    }

    /**
     * @param array $storageEntry
     *
     * @return array
     */
    public function extractEntries(array $storageEntry): array
    {
        return [
            static::SEARCH_NAME_FIELD, $this->extractFieldItemsReference($storageEntry),
        ];
    }

    /**
     * @param array $storageEntry
     *
     * @return array
     */
    protected function extractFieldItemsReference(array $storageEntry): array
    {
        $items = [];

        foreach ($storageEntry['fields'][static::FIELD_ITEMS]['value'] as $field) {
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
        $storageEntries = $this->contentfulQuery->filterByEntryId(strtolower($entryId));

        foreach ($storageEntries as $entry) {
            return $entry->getEntryId();
        }

        return null;
    }
}
