<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriter;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * Class ContentfulSearchPageBusinessFactory
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Business
 * @method ContentfulSearchPageQu
 */
class ContentfulPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriter
     */
    public function createContentfulPageSearchWriter(): ContentfulPageSearchWriter
    {
        return new ContentfulPageSearchWriter();
    }
}
