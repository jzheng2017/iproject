<?php
namespace EenmaalAndermaal\Controller;

use EenmaalAndermaal\Route\Router;

interface Controller {

    public function registerRoutes(Router &$router);

}