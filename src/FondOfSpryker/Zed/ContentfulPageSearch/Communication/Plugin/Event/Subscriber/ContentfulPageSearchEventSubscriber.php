<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Event\Listener\ContentfulPageSearchListener;
use FondOfSpryker\Zed\ContentfulPageSearch\Dependency\ContentfulEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ContentfulPageSearchEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $this->addContentfulPageSearchCreateListener();
        $this->addContentfulPageSearchDeleteListener();
        $this->addContentfulPageSearchPublishListener();
        $this->addContentfulPageSearchUnpublishListener();
        $this->addContentfulPageSearchUpdateListener();

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addContentfulPageSearchPublishListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_PAGE_PUBLISH, new ContentfulPageSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addContentfulPageSearchUnpublishListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_PAGE_UNPUBLISH, new ContentfulPageSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addContentfulPageSearchCreateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_PAGE_CREATE, new ContentfulPageSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addContentfulPageSearchUpdateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_PAGE_UPDATE, new ContentfulPageSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addContentfulPageSearchDeleteListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_PAGE_DELETE, new ContentfulPageSearchListener());
    }
}
