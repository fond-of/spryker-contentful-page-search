<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface ContentfulPageSearchToSearchFacadeInterface
{
    /**
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param string $mapperName
     *
     * @throws \Spryker\Zed\Search\Business\Exception\InvalidPropertyNameException
     *
     * @return array
     */
    public function transformPageMapToDocumentByMapperName(array $data, LocaleTransfer $localeTransfer, $mapperName): array;
}
