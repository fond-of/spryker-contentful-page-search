<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\Contentful\Dependency\ContentfulEvents;
use FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Event\Listener\ContentfulPageSearchListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\ContentfulStorage\Business\ContentfulStorageFacade getFacade()
 * @method \FondOfSpryker\Zed\ContentfulStorage\Communication\ContentfulStorageCommunicationFactory getFactory()
 */
class ContentfulPageSearchEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_CREATE, new ContentfulPageSearchListener());
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_UPDATE, new ContentfulPageSearchListener());

        return $eventCollection;
    }
}
