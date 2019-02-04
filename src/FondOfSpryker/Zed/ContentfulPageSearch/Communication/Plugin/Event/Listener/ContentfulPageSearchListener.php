<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Event\Listener;

use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * Class ContentfulPageSearchListener
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Event\Listener
 * @method CmsPageSearchFacadeInterface
 */
class ContentfulPageSearchListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    /**
     * @param array $transfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $transfers, $eventName): void
    {
    }
}
