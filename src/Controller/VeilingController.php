<?php

namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\App;
use EenmaalAndermaal\Model\FeedbackModel;
use EenmaalAndermaal\Model\FileModel;
use EenmaalAndermaal\Model\GebruikerModel;
use EenmaalAndermaal\Model\LandModelCollection;
use EenmaalAndermaal\Model\RubriekModelCollection;
use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Model\VeilingModelCollection;
use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Request\Response;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\Services\LoggingService;
use EenmaalAndermaal\Services\MailService;
use EenmaalAndermaal\Services\UserService;
use EenmaalAndermaal\Util\Debug;
use EenmaalAndermaal\Util\FileHandler;
use EenmaalAndermaal\View\CreateVeilingView;
use EenmaalAndermaal\View\VeilingDetailView;

class VeilingController implements Controller
{

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("veiling/{id}", RequestMethod::GET(), function (Request $request) {
            LoggingService::log("GET /veiling/" . $request->getVar("id"));
            $v = new VeilingModel();
            $v->getOne($request->getVar("id"));
            $view = new VeilingDetailView($v);
            $r = new ApiRequest("verkoper/{$v->verkoper}/feedback", RequestMethod::GET());
            $r->connect();
            $view->verkoper = new GebruikerModel();
            $view->verkoper->getOne($v->verkoper);
            $view->feedback = $r->getResult()[0];
            return ($view)->render();
        }));

        $router->addRoute(new Route("veiling/{id}", RequestMethod::POST(), function (Request $request) {
            if (UserService::getInstance()->userLoggedIn()) {
                $apiRequest = new ApiRequest("/veilingen/" . $request->getVar("id") . "/biedingen", RequestMethod::POST());
                $data = [
                    "bedrag" => $_POST['bedrag'] * 100,
                    "gebruiker" => UserService::getInstance()->getCurrentUser()->getIdentifier()
                ];
                if (!$apiRequest->connect($data)) {
                    die(new Response(500, "Server error", [
                        $apiRequest->getError()
                    ]));
                }
                LoggingService::log("POST /veiling/" . $request->getVar("id"), [
                    "bod" => $data
                ]);
            }
            header("Location: " . App::getApp()->getConfig()->get("website.url") . "veiling/" . $request->getVar("id"));
            die();
        }));

        $router->addRoute(new Route("sluitveilingen", RequestMethod::POST(), function (Request $request) {
            $r = new ApiRequest("veilingen/manage/sluit", RequestMethod::GET());
            $gesloten = 0;
            if ($r->connect()) {
                (new ApiRequest("veilingen/manage/sluit", RequestMethod::POST()))->connect();
                $vm = new VeilingModelCollection();
                $vm->fromResultSet($r->getResult());
                foreach ($vm as $value) {
                    /** @var $value VeilingModel */
                    $g = new GebruikerModel();
                    $g->map($value->koper);
                    $mail = new MailService("veiling_gewonnen");
                    $mail->addVar('voornaam', $g->voornaam);
                    $mail->addVar('titel', $value->titel);
                    $mail->addVar('id', $value->getIdentifier());
                    if ($mail->sendMail($g->email, 'Veiling gewonnen!')) {
                        $gesloten++;
                    }
                }

            }
            return new Response(200, "success", [
                "gesloten" => $gesloten
            ]);
        }));
        $router->addRoute(new Route("veiling-aanmaken", RequestMethod::GET(), function (Request $request) {
            $view = new CreateVeilingView();
            $view->landen = new LandModelCollection();
            $view->landen->getAll();
            $view->rubrieken = new RubriekModelCollection();
            $view->rubrieken->getTop();
            foreach ($view->rubrieken as $top) {
                $subRubrieken = new RubriekModelCollection();
                $subRubrieken->getAllByParent($top);
                $top->children = $subRubrieken;
            }

            return $view->render();
        }));
        $router->addRoute(new Route("veiling-aanmaken", RequestMethod::POST(), function (Request $request) {
            $view = new CreateVeilingView();
            $view->landen = new LandModelCollection();
            $view->landen->getAll();
            $veiling = new VeilingModel();
            $veiling->bind($request->getPost());
            $view->fields = $request->getPost();
            $veiling->tmpThumbnail = $_FILES['thumbnail'];
            $veiling->tmpImages = FileHandler::remapMultiFile($_FILES['images']);
            $view->errors = $veiling->verify();
            $view->rubrieken = new RubriekModelCollection();
            $view->rubrieken->getTop();

            foreach ($view->rubrieken as $top) {
                $subRubrieken = new RubriekModelCollection();
                $subRubrieken->getAllByParent($top);
                $top->children = $subRubrieken;
            }
            if (count($view->errors) < 1) {
                $success = $veiling->saveImages();
                $veiling->setValues();
                if ($success) {
                    if ($veiling->save()) {
                        $view->success = true;
                    }
                } else {
                    $view->errors[] = "Er is iets mis gegaan met het uploaden van de veiling. Excuses voor het ongemak. Probeer het opnieuw.";
                }
            }

            return $view->render();
        }));
    }
}