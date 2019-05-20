<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\View;

class LegalController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("PrivacyVerklaring", RequestMethod::GET(), function() {
            $view = new View("wetgeving\PrivacyVerklaring");
            return $view->render();
        }));
    }
}