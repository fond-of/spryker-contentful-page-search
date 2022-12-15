<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use Generated\Shared\Transfer\PageMapTransfer;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 */
abstract class AbstractContentfulTypeMapperPlugin extends AbstractPlugin
{
    /**
     * @var string
     */
    public const ID_CONTENTFUL = 'id_contentful';

    /**
     * @var string
     */
    public const ENTRY_ID = 'entry_id';

    /**
     * @var string
     */
    public const ENTRY_TYPE_ID = 'entry_type_id';

    /**
     * @var string
     */
    public const ENTRY_LOCALE = 'entry_locale';

    /**
     * @var string
     */
    public const FIELD_TYPE_REFERENCE = 'Reference';

    /**
     * @var string
     */
    protected $entryTypeId;

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
        $contentfulQuery = $this->getFactory()->getContentfulQuery();
        $contentfulQuery->clear();

        return $contentfulQuery
            ->filterByIdContentful($contentfulId)
            ->findOne();
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

        if (!isset($data['fields'][$name])) {
            return $items;
        }

        foreach ($data['fields'][$name]['value'] as $field) {
            if ($field['type'] === static::FIELD_TYPE_REFERENCE) {
                $items[] = $this->getRelatedItemEntryId($field['value']);
            }
        }

        return $items;
    }

    /**
     * @param string $entryId
     *
     * @return string|null
     */
    abstract protected function getRelatedItemEntryId(string $entryId): ?string;

    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $data
     * @param array $mapper
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    abstract protected function mapSearchResults(
        PageMapBuilderInterface $pageMapBuilder,
        PageMapTransfer $pageMapTransfer,
        array $data,
        array $mapper
    ): PageMapTransfer;
}
