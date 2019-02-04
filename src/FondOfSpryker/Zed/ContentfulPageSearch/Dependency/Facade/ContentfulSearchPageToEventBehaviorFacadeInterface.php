<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade;

interface ContentfulSearchPageToEventBehaviorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return array
     */
    public function getEventTransferIds(array $eventTransfers);

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     * @param string $foreignKeyColumnName
     *
     * @return array
     */
    public function getEventTransferForeignKeys(array $eventTransfers, $foreignKeyColumnName);
}
