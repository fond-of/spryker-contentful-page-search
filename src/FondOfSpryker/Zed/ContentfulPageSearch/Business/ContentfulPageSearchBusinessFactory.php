<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriter;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * Class ContentfulSearchPageBusinessFactory
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Business
 * @method ContentfulSearchPageQu
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchQueryContainer getQueryContainer()
 */
class ContentfulPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Search\ContentfulPageSearchWriter
     */
    public function createContentfulPageSearchWriter(): ContentfulPageSearchWriter
    {
        return new ContentfulPageSearchWriter(
            $this->createContentfulQuery(),
            $this->createFosContentfulPageSearchQuery()
        );
    }

    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected function createContentfulQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }

    /**
     * @return \Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearchQuery
     */
    protected function createFosContentfulPageSearchQuery(): FosContentfulPageSearchQuery
    {
        return FosContentfulPageSearchQuery::create();
    }
}
