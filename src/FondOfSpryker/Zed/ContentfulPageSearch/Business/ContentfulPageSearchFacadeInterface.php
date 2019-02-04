<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business;

interface ContentfulPageSearchFacadeInterface
{
    /**
     * @param array $idCollection
     *
     * @return void
     */
    public function publish(array $idCollection): void;

    /**
     * @param array $idCollection
     *
     * @return void
     */
    public function unpublish(array $idCollection): void;
}
