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
use EenmaalAndermaal\Services\GetService;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\Services\MailService;
use EenmaalAndermaal\Services\UserService;
use EenmaalAndermaal\View\ProfileView;
use EenmaalAndermaal\View\VerkoperRegistratieView;
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
            if (UserService::getInstance()->getCurrentUser()->permissie > 0) {
                $veilingen = new ApiRequest("verkoper/" . UserService::getInstance()->getCurrentUser()->getIdentifier() . "/veilingen", RequestMethod::GET());
                if ($veilingen->connect()) {
                    $view->veilingen = $veilingen->getResult();
                }
            }
            $view->geboden = [];
            $geboden = new ApiRequest("gebruikers/". UserService::getInstance()->getCurrentUsername()."/veilingen", RequestMethod::GET());
            if ($geboden->connect()){
                $geboden = $geboden->getResult();
                $unique = [];
                $view->geboden = array_filter($geboden, function($veiling) use (&$unique) {
                    if (!in_array($veiling['nummer'], $unique)) {
                        $unique[] = $veiling['nummer'];
                        return true;
                    }
                    return false;
                });
            }
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

        $router->addRoute(new Route("verkoperWorden", RequestMethod::GET(), function (Request $request) {
            $view = new VerkoperRegistratieView();
            return $view->render();
        }));

        $router->addRoute(new Route("verkoperWorden", RequestMethod::POST(), function (Request $request) {
            $gebruikersnaam = UserService::getInstance()->getCurrentUser()->gebruikersnaam;
            $r = new ApiRequest("gebruikers/{$gebruikersnaam}", RequestMethod::POST());

            $data = $request->getPost();

            if ($r->connect([
                "permissie" => 1
            ])) {
                header("Location: " . App::getApp()->getConfig()->get("website.url"));
                die();
            };
        }));

        $router->addRoute(new Route("wachtwoord-vergeten", RequestMethod::GET(), function (Request $request) {
            LoggingService::log("GET /wachtwoord-vergeten");
            $view = new View("user/forgotpassword");
            $view->homepage = false;
            return $view->render();
        }));

        $router->addRoute(new Route("wachtwoord-vergeten", RequestMethod::POST(), function (Request $request) {
            if (isset($request->getPost()['email'])) {
                $email = $request->getPost()['email'];
                LoggingService::log("POST /wachtwoord-vergeten", [
                    "email" => $email,
                ]);
                $gebruiker = new GebruikerModel();
                $view = new View("user/password_mail_success");
                $view->status = false;
                if ($gebruiker->getByEmail($email)) {
                    $view->status = true;
                    $mail = new MailService("password");
                    $mail->addVar("voornaam", $gebruiker->voornaam);
                    $mail->addVar("token", $gebruiker->getToken());
                    $mail->addVar("gebruikersnaam", $gebruiker->getIdentifier());
                    $mail->sendMail($gebruiker->email, "Wachtwoord vergeten EenmaalAndermaal");
                }
                return $view->render();
            }
            header("Location: " . App::getApp()->getConfig()->get("website.url") . "wachtwoord-vergeten");
            die();
        }));

        $router->addRoute(new Route("wachtwoord-reset/{gebruikersnaam}", RequestMethod::GET(), function () {
            $token = GetService::getInstance()->getVar("token");
            $gebruiker = new GebruikerModel();
            $view = new View("user/newpassword");
            $view->status = false;
            if ($token && $gebruiker->getByToken($token)) {
                $view->status = true;
                $view->gebruikersnaam = $gebruiker->gebruikersnaam;
            }
            return $view->render();
        }));

        $router->addRoute(new Route("wachtwoord-reset/{gebruikersnaam}", RequestMethod::POST(), function (Request $request) {
            $token = GetService::getInstance()->getVar("token");
            $gebruiker = new GebruikerModel();
            $view = new View("user/newpassword");
            $view->status = false;
            if ($token && $gebruiker->getByToken($token)) {
                $view->status = true;
                $view->gebruikersnaam = $gebruiker->gebruikersnaam;
                $post = $request->getPost();
                if (isset($post['password']) && isset($post['password2']) && $post['password'] == $post['password2']) {
                    $view->error = $gebruiker->validatePassword($post['password']);
                    if (!count($view->error)) {
                        if ($gebruiker->resetPassword($post['password'])) {
                            return (new View("user/password_reset_success"))->render();
                        }
                        $view->error = "SERVER ERROR: Probeer opnieuw of neem contact op met de klantenservice.";
                    }
                } else {
                    $view->error = ["Wachtwoorden moeten gelijk zijn!"];
                }
            }
            return $view->render();
        }));

        $router->addRoute(new Route("verwijder", RequestMethod::GET(), function () {
            LoggingService::log("GET /verwijderAVG");
            if (UserService::getInstance()->userLoggedIn()) {
                return (new View("user/avg_delete"))->render();
            }
            header("Location: " . App::getApp()->getConfig()->get("website.url"));
            die();
        }));


        $router->addRoute(new Route("verwijder", RequestMethod::POST(), function () {
            if (UserService::getInstance()->userLoggedIn()) {
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