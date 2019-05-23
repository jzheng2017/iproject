<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\View;

class LoginController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("Login", RequestMethod::GET(), function() {
            $view = new View("login/Login");
            return $view->render();
        }));
    }
}