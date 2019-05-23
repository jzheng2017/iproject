<?php


namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\ProfileView;
use EenmaalAndermaal\View\View;


class UserController implements Controller
{
    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("user/profile", RequestMethod::GET(), function () {
            $view = new ProfileView("user/profile");
            $view->homepage = false;
            return $view->render();
        }));

        $router->addRoute(new Route("forgotpassword", RequestMethod::GET(), function () {
          $view = new View("user/forgotpassword");
          $view->homepage = false;
          return $view->render();
        }));

        $router->addRoute(new Route("newpassword",RequestMethod::GET(),function () {
            $view = new View("user/newpassword");
            $view->homepage = false;
            return $view->render();
        }));
    }
}