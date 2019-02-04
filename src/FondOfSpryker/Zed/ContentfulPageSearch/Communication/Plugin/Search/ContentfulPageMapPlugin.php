<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search;

use FondOfSpryker\Shared\ContentfulPageSearch\ContentfulPageSearchConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Search\Dependency\Plugin\NamedPageMapInterface;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

class ContentfulPageMapPlugin extends AbstractPlugin implements NamedPageMapInterface
{
    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function buildPageMap(PageMapBuilderInterface $pageMapBuilder, array $data, LocaleTransfer $localeTransfer): PageMapTransfer
    {
        $pageMapTransfer = (new PageMapTransfer())
            ->setStore($data['store'])
            ->setLocale($data['locale'])
            ->setType($data['type'])
            ->setIsActive($data['is_active']);

        return $pageMapTransfer;
    }

    /**
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search\ageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $data
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search\caleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    protected function expandContentfulPageMap(PageMapTransfer $pageMapTransfer, PageMapBuilderInterface $pageMapBuilder, array $data, caleTransfer $localeTransfer): PageMapTransfer
    {
        return $pageMapTransfer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return ContentfulPageSearchConstants::CONTENTFUL_RESOURCE_NAME;
    }
}
