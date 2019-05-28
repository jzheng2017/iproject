<?php


namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Model\VeilingModelCollection;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Services\GetService;
use EenmaalAndermaal\Services\ZipcodeService;
use EenmaalAndermaal\Util\Debug;
use EenmaalAndermaal\View\ZoekResultaatView;

class ZoekResultaatController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("zoekresultaat", RequestMethod::GET(), function (Request $request) {
            $view = new ZoekResultaatView();
            $view->zoekresultaat = new VeilingModelCollection();
            $get = GetService::getInstance();
            $params = [];
            if ($get->getVar("zoeken")) {
                $params['search'] = $get->getVar("zoeken");
            }
            if ($get->getVar("rubriek") != -1) {
                $params['rubriek'] = $get->getVar("rubriek");
            }
            if ($get->getVar("minPrijs")) {
                $params['minPrijs'] = $get->getVar("minPrijs") * 100;
            }
            if ($get->getVar("maxPrijs")) {
                $params['maxPrijs'] = $get->getVar("maxPrijs") * 100;
            }
            if ($get->getVar("maxAfstand") && $get->getVar("maxAfstand") != -1) {
                $params['afstand'] = $get->getVar("maxAfstand");
            }
            if ($get->getVar("postcode")) {
                list($params['lat'], $params['long']) = ZipcodeService::getLatLong($get->getVar("postcode"));
            }
            $view->zoekresultaat->search($params);
            return $view->render();
        }));
    }
}