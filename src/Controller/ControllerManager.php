<?php
namespace EenmaalAndermaal\Controller;
use EenmaalAndermaal\Configuration\Config;
use EenmaalAndermaal\Route\Router;

class ControllerManager {

    /**
     * @var ControllerManager $manager
     */
    private static $manager;

    /**
     * @var Controller[] $controllers
     */
    private $controllers;

    // add the controllers
    private function createControllers()
    {
        $controllers = (new Config("controller.config"))->get("controllers");
        foreach ($controllers as $controller) {
            $this->addController(new $controller());
        }
    }

    public static function getManager(Router &$router): ControllerManager
    {
        if (empty(self::$manager)) {
            self::$manager = new ControllerManager($router);
        }
        return self::$manager;
    }

    public function __construct(Router &$router)
    {
        $this->controllers = [];
        $this->createControllers();
        $this->registerControllers($router);
    }

    private function addController(Controller $controller)
    {
        $this->controllers[] = $controller;
    }

    private function registerControllers(Router &$router)
    {
        foreach ($this->controllers as $controller) {
            $controller->registerRoutes($router);
        }
    }
}