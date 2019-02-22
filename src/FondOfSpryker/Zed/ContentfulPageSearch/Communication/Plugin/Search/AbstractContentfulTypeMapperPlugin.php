<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Generated\Shared\Transfer\PageMapTransfer;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 */
abstract class AbstractContentfulTypeMapperPlugin extends AbstractPlugin
{
    public const ID_CONTENTFUL = 'id_contentful';

    public const ENTRY_ID = 'entry_id';

    public const ENTRY_TYPE_ID = 'entry_type_id';

    public const ENTRY_LOCALE = 'entry_locale';

    /**
     * @return string
     */
    public function getEntryTypeId(): string
    {
        return $this->entryTypeId;
    }

    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    protected function defaultMapSearchResults(PageMapBuilderInterface $pageMapBuilder, PageMapTransfer $pageMapTransfer, array $data): PageMapTransfer
    {
        $pageMapBuilder
            ->addSearchResultData($pageMapTransfer, static::ID_CONTENTFUL, $data[static::ID_CONTENTFUL])
            ->addSearchResultData($pageMapTransfer, static::ENTRY_ID, $data[static::ENTRY_ID])
            ->addSearchResultData($pageMapTransfer, static::ENTRY_TYPE_ID, $data[static::ENTRY_TYPE_ID])
            ->addSearchResultData($pageMapTransfer, static::ENTRY_LOCALE, $data[static::ENTRY_LOCALE])
            ->addFullTextBoosted($pageMapTransfer, $data[static::ENTRY_ID])
            ->addFullTextBoosted($pageMapTransfer, $data[static::ENTRY_TYPE_ID])
            ->addFullTextBoosted($pageMapTransfer, $data[static::ENTRY_LOCALE]);

        return $pageMapTransfer;
    }

    /**
     * @param int $contentfulId
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful
     */
    protected function getContentfulEntity(int $contentfulId): FosContentful
    {
        $contentfulQuery = $this->getFactory()->createContentfulQuery();
        $contentfulQuery->clear();

        return $contentfulQuery
            ->filterByIdContentful($contentfulId)
            ->findOne();
    }

    /**
     * @param int $contentfulId
     *
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\Base\FosContentfulPageSearch
     */
    protected function getContentfulPageSearchEntity(int $contentfulId): FosContentfulPageSearch
    {
        $contentfulPageSearchQuery = $this->getFactory()->createContentfulPageSearchQuery();
        $contentfulPageSearchQuery->clear();

        return $this->contentfulPageSearchQuery
            ->filterByFkContentful($contentfulId)
            ->findOneOrCreate();
    }

    /**
     * @param string $name
     * @param array $data
     *
     * @return array
     */
    protected function extractReferenceField(string $name, array $data): array
    {
        $items = [];

        foreach ($data['fields'][$name]['value'] as $field) {
            if ($field['type'] === static::FIELD_TYPE_REFERENCE) {
                array_push($items, $this->getRelatedItemEntryId($field['value']));
            }
        }

        return $items;
    }

    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $data
     * @param array $mapper
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    abstract protected function mapSearchResults(PageMapBuilderInterface $pageMapBuilder, PageMapTransfer $pageMapTransfer, array $data, array $mapper): PageMapTransfer;
}
