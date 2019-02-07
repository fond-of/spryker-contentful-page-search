<?php

namespace FondOfSpryker\Service\ContentfulPageSearch\Plugin;

use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Service\Kernel\AbstractPlugin;
use Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface;

/**
 * Class ContentfulStorageKeyGeneratorPlugin
 * @package FondOfSpryker\Service\ContentfulStorage\Plugin
 * @method \FondOfSpryker\Service\ContentfulPageSearch\ContentfulPageSearchServiceFactory getFactory()
 */
class ContentfulPageSearchKeyGeneratorPlugin extends AbstractPlugin implements SynchronizationKeyGeneratorPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\SynchronizationDataTransfer $dataTransfer
     *
     * @return string
     */
    public function generateKey(SynchronizationDataTransfer $dataTransfer): string
    {
        /** @var \Orm\Zed\Contentful\Persistence\FosContentful $entity */
        $entity = $this->getFactory()
            ->createFosContentfulQuery()
            ->findPk($dataTransfer->getReference());

        return $entity->getStorageKey();
    }
}
