<?php


namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Util\Debug;
use EenmaalAndermaal\View\RegistratieView;

class GebruikersController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("registreren", RequestMethod::GET(), function (Request $request) {
            return (new RegistratieView())->render();
        }));

        $router->addRoute(new Route("registreren", RequestMethod::POST(), function (Request $request) {
            return (new RegistratieView())->render();
        }));
    }
}