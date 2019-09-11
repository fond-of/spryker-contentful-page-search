<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade;

interface ContentfulPageSearchToContentfulFacadeInterface
{
    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return mixed
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null);

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array;

    /**
     * @return int
     */
    public function getContentfulEntryCount(): int;
}
