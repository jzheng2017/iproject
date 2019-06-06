<?php

namespace EenmaalAndermaal\Controller;


use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\Util\Debug;
use EenmaalAndermaal\View\VerificatieView;

class VerificatieController implements Controller
{
    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("profiel/{gebruiker}/confirm/{token}", RequestMethod::GET(), function (Request $request) {
            $token = $request->getVar('token');
            $view = new VerificatieView();
            $view->naam = $request->getVar("gebruiker");
            $r = new ApiRequest("gebruikers/{$view->naam}/verify", RequestMethod::POST(), ['token' => $token]);
            $view->bestaat = false;
            if ($r->connect()) {
                $view->bestaat = isset($r->getResult()['affected']);
            }
            LoggingService::log("/profiel/{$view->naam}/confirm/{$token}", [
                "success" => $view->bestaat
            ]);
            return $view->render();
        }));
    }
}