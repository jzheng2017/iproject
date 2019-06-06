<?php

namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\App;
use EenmaalAndermaal\Model\GebruikerModel;
use EenmaalAndermaal\Model\LandModelCollection;
use EenmaalAndermaal\Model\VraagModelCollection;
use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\Services\MailService;
use EenmaalAndermaal\Services\SessionService;
use EenmaalAndermaal\Services\UserService;
use EenmaalAndermaal\Util\Debug;
use EenmaalAndermaal\View\RegistratieView;
use EenmaalAndermaal\View\View;

class LoginController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("login", RequestMethod::GET(), function (Request $request) {
            LoggingService::log("/login");
            $view = new View("login/Login");
            return $view->render();
        }));

        $router->addRoute(new Route("uitloggen", RequestMethod::GET(), function () {
            LoggingService::log("/logout");
            UserService::getInstance()->logout();
            header("Location: " . App::getApp()->getConfig()->get("website.url"));
        }));

        $router->addRoute(new Route("login", RequestMethod::POST(), function (Request $request) {
            $view = new View("login/Login");
            $post = $request->getPost();
            $view->error = "";
            if (isset($post['gebruikersnaam'])) {
                if (isset($post['wachtwoord'])) {
                    $gebruikersnaam = $post['gebruikersnaam'];
                    $wachtwoord = $post['wachtwoord'];
                    $r = new ApiRequest("gebruikers/{$gebruikersnaam}/login", RequestMethod::POST());
                    if ($r->connect(['password' => $wachtwoord])) {
                        $result = $r->getResult();
                        if (isset($result['login']) && $result['login']) {
                            LoggingService::log("login", [
                                "login" => true,
                                "user" => $gebruikersnaam
                            ]);
                            SessionService::getInstance()->set("userId", $gebruikersnaam);
                            header("Location: " . App::getApp()->getConfig()->get("website.url"));
                            die();
                        } else {
                            $view->error = 'Wachtwoord en gebruikersnaam combinatie klopt niet';
                        }
                    } else {
                        $view->error = 'Wachtwoord en gebruikersnaam combinatie klopt niet';
                    }
                    LoggingService::log("/login", [
                        "login" => false,
                        "user" => $gebruikersnaam
                    ]);
                } else {
                    $view->error = "Geen wachtwoord gevonden";
                }
            } else {
                $view->error = "Geen gebruikersnaam gevonden";
            }

            return $view->render();
        }));

        $router->addRoute(new Route("registreren", RequestMethod::GET(), function (Request $request) {
            $v = new RegistratieView();
            $v->vragen = new VraagModelCollection();
            $v->vragen->getAll();
            $v->landen = new LandModelCollection();
            $v->landen->getAll();
            return $v->render();
        }));

        $router->addRoute(new Route("registreren", RequestMethod::POST(), function (Request $request) {
            $user = new GebruikerModel();
            $user->bind($request->getPost());
            $view = new RegistratieView();
            $view->vragen = new VraagModelCollection();
            $view->vragen->getAll();
            $view->landen = new LandModelCollection();
            $view->landen->getAll();
            $view->errors = $user->validate();
            $view->fields = $request->getPost();
            $view->submit = true;
            if (count($view->errors) < 1) {
                if ($user->save()) {
                    $mail = new MailService("verify");
                    $mail->addVar("voornaam", $user->voornaam);
                    $mail->addVar("token", $user->getToken());
                    $mail->addVar("gebruikersnaam", $user->getIdentifier());
                    $mail->sendMail($user->email, "Verificatie account EenmaalAndermaal");
                    return (new View("registreren/success"))->render();
                } else {
                    $view->errors[] = "Fout tijdens het registreren. Probeer opnieuw of neem contact";
                }
            }
            return $view->render();
        }));
    }
}