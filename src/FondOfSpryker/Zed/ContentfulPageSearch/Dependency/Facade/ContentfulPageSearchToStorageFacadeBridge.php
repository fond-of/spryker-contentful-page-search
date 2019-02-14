<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade;

use Spryker\Zed\Storage\Business\StorageFacadeInterface;

class ContentfulPageSearchToStorageFacadeBridge implements ContentfulPageSearchToStorageFacadeInterface
{
    /**
     * @var \Spryker\Zed\Storage\Business\StorageFacadeInterface
     */
    protected $storageFacade;

    /**
     * @param \Spryker\Zed\Storage\Business\StorageFacadeInterface $storageFacade
     */
    public function __construct(StorageFacadeInterface $storageFacade)
    {
        $this->storageFacade = $storageFacade;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->storageFacade->get($key);
    }
}
