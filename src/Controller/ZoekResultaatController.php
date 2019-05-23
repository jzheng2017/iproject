<?php


namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Model\VeilingModelCollection;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\View\ZoekResultaatView;

class ZoekResultaatController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("zoekresultaat/{keywords}", RequestMethod::GET(), function (Request $request) {
            $view = new ZoekResultaatView();
            $view->collection = new VeilingModelCollection();
            return $view->render();
        }));
    }
}