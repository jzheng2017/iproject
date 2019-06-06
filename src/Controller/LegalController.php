<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\View\View;

class LegalController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("privacyverklaring", RequestMethod::GET(), function() {
            LoggingService::log("GET /privacyverklaring");
            $view = new View("wetgeving\PrivacyVerklaring");
            return $view->render();
        }));
    }
}