<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * Class ContentfulPageSearchFacade
 *
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Business
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchBusinessFactory getFactory()
 */
class ContentfulPageSearchFacade extends AbstractFacade implements ContentfulPageSearchFacadeInterface
{
    /**
     * @param array $idCollection
     *
     * @return void
     */
    public function publish(array $idCollection): void
    {
        $this->getFactory()
            ->createContentfulPageSearchWriter()
            ->publish($idCollection);
    }

    /**
     * @param array $idCollection
     *
     * @return void
     */
    public function unpublish(array $idCollection): void
    {
        // TODO: Implement unpublish() method.
    }
}
