<?php


namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\FaqView;

class FaqController implements Controller
{
    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("faq", RequestMethod::GET(), function (Request $request) {
            $view = new FaqView();
            return $view->render();
        }));
    }
}