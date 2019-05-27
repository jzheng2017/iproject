<?php

namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\GebruikerModel;
use EenmaalAndermaal\Model\LandModelCollection;
use EenmaalAndermaal\Model\VraagModelCollection;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\MailService;
use EenmaalAndermaal\View\RegistratieView;
use EenmaalAndermaal\View\View;

class LoginController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("login", RequestMethod::GET(), function () {
            $view = new View("login/Login");
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