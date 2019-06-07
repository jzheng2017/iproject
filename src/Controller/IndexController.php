<?php
namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Model\VeilingModelCollection;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\LocationService;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\View\View;

class IndexController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("", RequestMethod::GET(), function() {
            LoggingService::log("GET /");
            $view = new View("homepage/homepage");
            $view->homepage = true;
            $collection = new VeilingModelCollection();
            $collection->getTopThree();
            $view->collection = $collection;
            $view->near = new VeilingModelCollection();
            $view->near->getNearby(...LocationService::getUserLocation());
            return $view->render();
        }));
    }
}