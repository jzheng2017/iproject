<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\RegistratieModel;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\MailService;
use EenmaalAndermaal\View\RegistratieView;
use EenmaalAndermaal\View\View;

class LoginController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("Login", RequestMethod::GET(), function() {
            $view = new View("login/Login");
            return $view->render();
        }));
        $router->addRoute(new Route("registreren", RequestMethod::GET(), function (Request $request) {
            return (new RegistratieView())->render();
        }));
        $router->addRoute(new Route("registreren", RequestMethod::POST(), function (Request $request) {
            $register = new RegistratieModel();
            $register->fields = $request->getPost();
            $view = new RegistratieView();
            $view->errors = $register->verify();
            $view->fields = $request->getPost();
//            if (empty($register->fields)){
//                $mail = new MailService("verify");
//                $mail->sendMail($register->fields['email'],"Bevestiging registratie");
//            }
            return ($view->render());
        }));
    }
}