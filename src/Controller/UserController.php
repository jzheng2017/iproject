<?php


namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\App;
use EenmaalAndermaal\Model\LandModelCollection;
use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Model\GebruikerModel;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Request\Response;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\Services\UserService;
use EenmaalAndermaal\View\ProfileView;
use EenmaalAndermaal\View\View;


class UserController implements Controller
{
    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("profiel", RequestMethod::GET(), function (Request $request) {
            LoggingService::log("GET /profiel");
            $view = new ProfileView();
            $user = new GebruikerModel();
            $view->landen = new LandModelCollection();
            $view->landen->getAll();
            $user->bind($request->getPost());
            $view->homepage = false;
            return $view->render();
        }));

        $router->addRoute(new Route("profiel", RequestMethod::POST(), function (Request $request) {
            $gebruikersnaam = UserService::getInstance()->getCurrentUser()->gebruikersnaam;
            $r = new ApiRequest("gebruikers/{$gebruikersnaam}", RequestMethod::POST());

            $data = $request->getPost();

            if (!$r->connect([
                "voornaam" => $data['Voornaam'],
                "achternaam" => $data['Achternaam'],
                "plaatsnaam" => $data['Stad'],
                "land" => $data['Land'],
                "email" => $data['Email'],
                "telefoonnummer" => $data['Telefoon'],
                "postcode" => $data['postcode'],
                "adres" => $data['adres']
            ])) {
                return new Response(200, "success", $data);
            };
            return new Response(200, "succes", $request->getPost());
        }));

        $router->addRoute(new Route("wachtwoord-vergeten", RequestMethod::GET(), function () {
            LoggingService::log("GET /wachtwoord-vergeten");
            $view = new View("user/forgotpassword");
            $view->homepage = false;
            return $view->render();

        }));

        $router->addRoute(new Route("wachtwoordvergeten", RequestMethod::GET(), function () {
            $view = new View("gebruiker/forgotpassword");
            $view->homepage = false;
            return $view->render();
        }));

        $router->addRoute(new Route("wachtwoord-reset", RequestMethod::GET(), function () {
            LoggingService::log("GET /wachtwoord-reset");
            $view = new View("user/newpassword");
            $view->homepage = false;
            return $view->render();
        }));

        $router->addRoute(new Route("verwijderAVG", RequestMethod::GET(), function () {
            LoggingService::log("GET /verwijderAVG");
            if (UserService::getInstance()->userLoggedIn()) {
                return new View("GET user/avg_delete");
            }
            header("Location: " . App::getApp()->getConfig()->get("website.url"));
            die();
        }));


        $router->addRoute(new Route("verwijderAVG", RequestMethod::POST(), function () {
            if (UserService::getInstance()->userLoggedIn()) {
                UserService::getInstance()->logout();
                $gebruikersnaam = UserService::getInstance()->getCurrentUser()->gebruikersnaam;
                $r = new ApiRequest("gebruikers/{$gebruikersnaam}/delete", RequestMethod::POST());
                if ($r->connect()) {
                    LoggingService::log("POST /verwijderAVG", [
                        "delete" => true
                    ]);
                    UserService::getInstance()->logout();
                    header("Location: " . App::getApp()->getConfig()->get("website.url"));
                    die();
                } else {
                    LoggingService::log("POST /verwijderAVG", [
                        "delete" => false
                    ]);
                    return new Response(500, "Server error", $r->getError());
                }
            }
            header("Location: " . App::getApp()->getConfig()->get("website.url"));
            die();
        }));
    }
}