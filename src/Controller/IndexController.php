<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\View;

class IndexController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("", RequestMethod::GET(), function() {
            $view = new View("homepage/homepage");
            $view->homepage = true;
            $view->collection = [];
            return $view->render();
        }));
    }
}