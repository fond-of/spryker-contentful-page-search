<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface ContentfulPageSearchToStoreFacadeInterface
{
    /**
     * @param int $idStore
     *
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStoreById(int $idStore): StoreTransfer;
}
