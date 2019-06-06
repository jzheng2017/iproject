<?php

namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\RubriekModel;
use EenmaalAndermaal\Model\VeilingModelCollection;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\GetService;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\Services\ZipcodeService;
use EenmaalAndermaal\View\Component\BreadcrumbComponent;
use EenmaalAndermaal\View\View;

class RubriekenController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("rubrieken/{id}", RequestMethod::GET(), function (Request $request) {
            $view = new View("rubrieken/rubrieken");
            $rubriek = new RubriekModel();
            $rubriek->getOne($request->getVar("id"));
            $rubriek->includeChildren(true);
            $view->activeId = 0;
            $view->rubriek = $rubriek;
            $view->collection = new VeilingModelCollection();
            $params = [];
            $get = GetService::getInstance();
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
            LoggingService::log("GET /rubrieken/" . $request->getVar("id"), $params);
            $view->collection->getByTopParent($request->getVar("id"), $params);
            $view->breadCrumbComponent = new BreadcrumbComponent([
                [
                    "url" => "rubrieken/{$rubriek->nummer}",
                    "text" => $rubriek->naam
                ]
            ]);
            return $view->render();
        }));

        $router->addRoute(new Route("rubrieken/{id}/{naam}/{sub}", RequestMethod::GET(), function (Request $request) {
            $view = new View("rubrieken/rubrieken");
            $rubriek = new RubriekModel();
            $rubriek->getOne($request->getVar("id"));
            $rubriek->includeChildren(true);
            $view->activeId = $request->getVar("sub");
            $view->rubriek = $rubriek;
            $view->subRubriek = new RubriekModel();
            $view->subRubriek->getOne($view->activeId);
            $view->collection = new VeilingModelCollection();
            $params = [];
            $get = GetService::getInstance();
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
            LoggingService::log("GET /rubrieken/" . $request->getVar("id") . "/" . $request->getVar("naam") . "/" . $request->getVar("sub"), $params);
            $view->collection->getByParent($view->activeId, $params);
            $view->breadCrumbComponent = new BreadcrumbComponent([
                [
                    "url" => "rubrieken/{$rubriek->nummer}",
                    "text" => $rubriek->naam
                ],
                [
                    "url" => 'rubrieken/'. $rubriek->getIdentifier() . '/' . str_replace("&", "en", $view->subRubriek->naam) . '/' . $view->subRubriek->getIdentifier(),
                    "text" => $view->subRubriek->naam
                ]
            ]);
            return $view->render();
        }));
    }
}