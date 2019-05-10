<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\View;

class VeilingController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("veiling/{id}", RequestMethod::GET(), function (Request $request) {
            $view = new View("veilingen/veiling_detail");
            $view->homepage = false;
            return $view->render();
        }));
    }
}