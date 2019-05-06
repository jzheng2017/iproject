<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Model\TestModel;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Route\Route;
use EenmaalAndermaal\Route\Router;
use EenmaalAndermaal\View\View;

class IndexController implements Controller {

    public function registerRoutes(Router &$router)
    {
        $router->addRoute(new Route("", RequestMethod::GET(), function() {
            $view = new View("test/test");
            $view->collection = $this->fakeCollection();
            return $view->render();
        }));
    }

    private function fakeCollection() {
        $model1 = new TestModel();
        $model1->name = "First component";
        $model1->description = "This is an example of a component being used";

        $model2 = new TestModel();
        $model2->name = "Second component";
        $model2->description = "As you can se the components can be bound with objects to have optimal reusable code";

        $m = new TestModel();
        $m->name = "Hello darkness my old friend!";
        $m->description = "lol";
        return [$model1, $model2, $m];
    }
}