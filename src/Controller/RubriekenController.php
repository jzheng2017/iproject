<?php

namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\RubriekModel;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
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
            return $view->render();
        }));

        $router->addRoute(new Route("rubrieken/{id}/{naam}/{sub}", RequestMethod::GET(), function (Request $request) {
            $view = new View("rubrieken/rubrieken");
            $rubriek = new RubriekModel();
            $rubriek->getOne($request->getVar("id"));
            $rubriek->includeChildren(true);
            $view->activeId = $request->getVar("sub");
            $view->rubriek = $rubriek;
            return $view->render();
        }));
    }
}