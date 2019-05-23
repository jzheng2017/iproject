<?php


namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\ProfileView;


class UserController implements Controller
{
    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("user/profile", RequestMethod::GET(), function () {
            $view = new ProfileView("user/profile");
            $view->homepage = false;
            return $view->render();
        }));
    }
}