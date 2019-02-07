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
 */
class ContentfulPageSearchTextBlockMapPlugin extends AbstractPlugin implements NamedPageMapInterface
{
    const CONTENTFUL_TYPE_ID = 'textBlock';

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
        $pageMaptransfer = (new PageMapTransfer())
            ->setStore(Store::getInstance()->getStoreName())
            ->setLocale($locale->getLocaleName())
            ->setType(static::CONTENTFUL_TYPE_ID)
            ->setIsActive(true);

        $pageMapBuilder
            ->addSearchResultData($pageMaptransfer, 'name', 'asdfasdfasdf')
            ->addSearchResultData($pageMaptransfer, 'contentful_entry_id', 9);

        return $pageMaptransfer;
    }
}
