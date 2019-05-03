<?php

namespace EenmaalAndermaal;

use EenmaalAndermaal\Configuration\Config;
use EenmaalAndermaal\Controller\ControllerManager;
use EenmaalAndermaal\Database\Database;
use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Route\Router;

class App
{

    /**
     * @var App $app
     */
    private static $app;

    private $request;

    /**
     * @var Router $route
     */
    private $router;

    private $controllerManager;

    /**
     * @var Database $database
     */
    private $database;

    /**
     * @var bool $production
     */
    private $production;

    /**
     * @var Config $config ;
     */
    private $config;

    public function __construct(bool $production)
    {
        self::$app = $this;
        //load configuration
        $this->production = $production;
        $this->request = new Request(isset($_GET['link']) ? $_GET['link'] : "");
        $this->router = new Router();
        $this->controllerManager = ControllerManager::getManager($this->router);
        $this->config = new Config("app.config");
    }

    public function getView()
    {
        return $this->router->getRoute($this->request->getLink(), $this->request->getMethod())->call($this->request);
    }

    public static function start(bool $production = true)
    {
        self::$app = new App($production);
    }

    public static function getApp(): App
    {
        return self::$app;
    }

    public function getDatabase()
    {
        if (empty($this->database)) {
            $this->database = new Database(
                $this->config->get("database.host"),
                $this->config->get("database.database"),
                $this->config->get("database.username"),
                $this->config->get("database.password"));
        }
        return $this->database;
    }

    public function isProduction(): bool
    {
        return $this->production;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}