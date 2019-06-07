<?php


namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\FeedbackModel;
use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\UserService;
use EenmaalAndermaal\View\FeedbackView;

class FeedbackController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("feedback/{id}", RequestMethod::GET(), function (Request $request) {
            $view = new FeedbackView();
            $r = new ApiRequest("veilingen/" . $request->getVar("id"), RequestMethod::GET());
            $r->connect();
            $veilingInfo = $r->getResult();
            if ($veilingInfo[0]['gesloten'] && $veilingInfo[0]['koper'] == UserService::getInstance()->getCurrentUser()->getIdentifier()) {
                $view->access = true;
                $r2 = new ApiRequest("veilingen/" . $request->getVar("id") . "/feedback", RequestMethod::GET());
                $r2->connect();
                $result = $r2->getResult();
                if ($result) {
                    $view->feedback = $result[0]['feedback'];
                    $view->commentaar = $result[0]['commentaar'];
                    $view->voorwerp = $result[0]['voorwerp'];
                    $view->dag = $result[0]['dag'];
                    $view->tijd = $result[0]['tijdstip'];
                }
            }else{
                $view->access = false;
            }
            return $view->render();
        }));

        $router->addRoute(new Route("feedback/{id}", RequestMethod::POST(), function (Request $request) {
            $view = new FeedbackView();
            $r = new ApiRequest("veilingen/" . $request->getVar("id"), RequestMethod::GET());
            $r->connect();
            $veilingInfo = $r->getResult();
            if ($veilingInfo[0]['gesloten'] && $veilingInfo[0]['koper'] == UserService::getInstance()->getCurrentUser()->getIdentifier()) {
                $f = new ApiRequest("veilingen/" . $request->getVar("id") . "/feedback", RequestMethod::GET());
                $f->connect();
                $result = $f->getResult();
                if (!$result) {
                    $r = new ApiRequest("veilingen/" . $request->getVar("id") . "/feedback", RequestMethod::POST());
                    $r->connect([
                        "voorwerp" => $request->getPost("id"),
                        "feedback" => $_POST['feedback'],
                        "commentaar" => $_POST['commentaar']

                    ]);
                } else {
                    $view->feedback = $result[0]['feedback'];
                    $view->commentaar = $result[0]['commentaar'];
                    $view->voorwerp = $result[0]['voorwerp'];
                    $view->dag = $result[0]['dag'];
                    $view->tijd = $result[0]['tijdstip'];

                }
            }else {
                $view->access = false;
            }
            return $view->render();
        }));
    }
}