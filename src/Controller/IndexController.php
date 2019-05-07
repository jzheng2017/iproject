<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\View;

class IndexController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("", RequestMethod::GET(), function() {
            $view = new View("homepage/homepage");
            $view->collection = $this->fakeCollection();
            return $view->render();
        }));
    }

    private function fakeCollection() {
        $model1 = new VeilingModel();
        $model1->name = "First component";
        $model1->description = "This is an example of a component being used";
        $model1->timer = "190:02:05";
        $model1->price = "290";
        $model1->image = "img/han.jpg";

        $model2 = new VeilingModel();
        $model2->name = "Second component";
        $model2->description = "As you can se the components can be bound with objects to have optimal reusable code";
        $model2->timer = "10:32:15";
        $model2->price = "90,25";
        $model2->image = "img/nah.jpg";

        $m = new VeilingModel();
        $m->name = "Hello darkness my old friend!";
        $m->description = "lol";
        $m->timer = "52:06:24";
        $m->price = "22,65";
        //$m->image = "img/hna.jpg";

        return [$model1, $model2, $m];
    }
}