<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\VeilingDetailView;

class VeilingController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("veiling/{id}", RequestMethod::GET(), function (Request $request) {
            $v = new VeilingModel();
            $v->getOne($request->getVar("id"));
            return (new VeilingDetailView($v))->render();
        }));
    }
}