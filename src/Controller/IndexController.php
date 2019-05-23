<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Model\VeilingModelCollection;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\MailService;
use EenmaalAndermaal\View\View;

class IndexController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("", RequestMethod::GET(), function() {
            $view = new View("homepage/homepage");
            $view->homepage = true;
            $collection = new VeilingModelCollection();
            $collection->getTopThree();
            $view->collection = $collection;
            return $view->render();
        }));

        $router->addRoute(new Route("mail/test/12341234/test123", RequestMethod::GET(), function (Request $request) {
            $mail = new MailService("verify");
            $mail->addVar("voornaam", "joey");
            $mail->addVar("token", "121dsg2vtudfsq");
            $mail->sendMail("joey.gameslabs@gmail.com", "Verificatie test");
            return $mail;
        }));
    }
}