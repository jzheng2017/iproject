<?php

namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\VerificatieView;

class VerificatieController implements Controller
{
    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("verificatie/{token}", RequestMethod::GET(), function (Request $request) {
            $token = $request->getVar('token');
            $view = new VerificatieView();
            $view->bestaat = false;
            return $view->render();
        }));
    }
}