<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Dependency\Facade;

interface ContentfulPageSearchToStorageFacadeInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);
}
