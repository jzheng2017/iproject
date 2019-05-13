<?php
require_once __DIR__ . "/vendor/autoload.php";

use EenmaalAndermaal\App;
define("BASEPATH", dirname(__FILE__) . "/");
App::start(false);
echo App::getApp()->getView();