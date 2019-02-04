<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Controller;

use Orm\Zed\ContentfulPageSearch\Persistence\FosContentfulPageSearch;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction()
    {
        $temp = new FosContentfulPageSearch();
        $temp->setContentfulEntryId(uniqid('foobar'));
        $temp->setLocale('de_DE');
        $temp->setStructuredData(serialize(['foo' => 'bar']));
        $temp->save();
        /*$temp->setData([
            'store' => 'AFFENZAHN_COM',
            'locale' => 'de_DE',
            'type' => 'cms_page',
            'is-active' => false,
            'search-result-data' =>
                array (
                    'id_cms_page' => 2,
                    'name' => 'foobar',
                    'type' => 'cms_page',
                    'url' => '/de/foobar',
                ),
            'full-text-boosted' =>
                array (
                    0 => 'foobar',
                ),
            'full-text' =>
                array (
                    0 => 'FICK DICH SPRYKER!!!,',
                ),
            'suggestion-terms' =>
                array (
                    0 => 'foobar',
                ),
            'completion-terms' =>
                array (
                    0 => 'foobar',
                ),
        ]);*/

        return $this->jsonResponse([
            'status' => 'success',
        ]);
    }
}
