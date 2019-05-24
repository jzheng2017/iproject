<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\App;
use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Request\Response;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\VeilingDetailView;

class VeilingController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("veiling/{id}", RequestMethod::GET(), function (Request $request) {
            $v = new VeilingModel();
            $v->getOne($request->getVar("id"));
            return (new VeilingDetailView($v))->render();
        }));

        $router->addRoute(new Route("veiling/{id}", RequestMethod::POST(), function (Request $request) {
            $apiRequest = new ApiRequest("veilingen/" . $request->getVar("id") . "/biedingen", RequestMethod::POST());
            if ($apiRequest->connect([
                "bedrag" => $_POST['bedrag'] * 100,
                "gebruiker" => 'TestGebruiker' //TODO: Change to logged in user
            ])) {
                header("Location: " . App::getApp()->getConfig()->get("website.url") . "veiling/" . $request->getVar("id") );
                die();
            }
            die(new Response(500, "Server error", [
                $apiRequest->getError()
            ]));
        }));
    }
}