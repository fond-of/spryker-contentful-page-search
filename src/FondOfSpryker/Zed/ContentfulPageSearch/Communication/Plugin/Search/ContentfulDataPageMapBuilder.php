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
    const TYPE = 'contentful_blog_post';

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
            ->setStore($this->getStoreNameFromData($data))
            ->setLocale($locale->getLocaleName())
            ->setType(static::TYPE)
            ->setIsActive(true);

        foreach ($this->getFactory()->getContentfulPageSeachMapperTypes() as $contentfulPageSeachMapperType) {
            if ($data['entry_type_id'] !== $contentfulPageSeachMapperType->getEntryTypeId() || !$contentfulPageSeachMapperType->isValidStructure($data)) {
                continue;
            }

            return $contentfulPageSeachMapperType->handle(
                $data['id_contentful'],
                $pageMapTransfer,
                $pageMapBuilder,
                $this->clearStoreNameFromData($data)
            );
        }

        return $pageMapTransfer;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function getStoreNameFromData(array $data): string
    {
        $storeName = Store::getInstance()->getStoreName();
        if (array_key_exists(ContentfulPageSearchConstants::STORE_NAME_FIELD, $data)){
            $storeName = $data[ContentfulPageSearchConstants::STORE_NAME_FIELD];
        }

        return $storeName;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function clearStoreNameFromData(array $data): array
    {
        if (array_key_exists(ContentfulPageSearchConstants::STORE_NAME_FIELD, $data)){
            unset($data[ContentfulPageSearchConstants::STORE_NAME_FIELD]);
        }

        return $data;
    }
}
