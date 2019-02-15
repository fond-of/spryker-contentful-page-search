<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;
use Spryker\Zed\Search\Dependency\Plugin\NamedPageMapInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacade getFacade()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 */
class ContentfulDataPageMapBuilder extends AbstractPlugin implements NamedPageMapInterface
{
    const TYPE = 'contentful_page';

    /**
     * @return string
     */
    public function getName()
    {
        return ContentfulPageSearchConstants::CONTENTFUL_RESOURCE_NAME;
    }

    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function buildPageMap(PageMapBuilderInterface $pageMapBuilder, array $data, LocaleTransfer $locale): PageMapTransfer
    {
        $pageMapTransfer = (new PageMapTransfer())
            ->setStore(Store::getInstance()->getStoreName())
            ->setLocale($locale->getLocaleName())
            ->setType(static::TYPE)
            ->setIsActive(true);

        foreach ($this->getFactory()->getContentfulPageSeachMapperTypes() as $contentfulPageSeachMapperType) {
            if ($data['entry_type_id'] !== $contentfulPageSeachMapperType->getEntryTypeId()) {
                continue;
            }

            $mapperTypes = $contentfulPageSeachMapperType->handle($data['id_contentful'], $pageMapBuilder);
            return $this->mapSearchResults($pageMapBuilder, $pageMapTransfer, $data, $mapperTypes);
        }

        return $pageMapTransfer;
    }

    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $data
     * @param array $mapperTypes
     *
     * @return \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface
     */
    protected function mapSearchResults(PageMapBuilderInterface $pageMapBuilder, PageMapTransfer $pageMapTransfer, array $data, array $mapperTypes): PageMapBuilderInterface
    {
        $pageMapBuilder
            ->addSearchResultData($pageMapTransfer, 'id_contentful', $data['id_contentful'])
            ->addSearchResultData($pageMapTransfer, 'entry_id', $data['entry_id'])
            ->addSearchResultData($pageMapTransfer, 'name', $data['entry_id'])
            ->addSearchResultData($pageMapTransfer, 'type', $data['entry_type_id'])
            ->addSearchResultData($pageMapTransfer, 'entry_locale', $data['entry_locale'])
            ->addSearchResultData($pageMapTransfer, 'url', '/de')
            ->addFullTextBoosted($pageMapTransfer, $data['entry_id'])
            ->addFullTextBoosted($pageMapTransfer, $data['entry_type_id'])
            ->addFullTextBoosted($pageMapTransfer, $data['entry_locale']);

        foreach ($mapperTypes as $key => $item) {
            $pageMapBuilder->addSearchResultData($pageMapTransfer, $key, $item);
        }

        return $pageMapBuilder;
    }
}
