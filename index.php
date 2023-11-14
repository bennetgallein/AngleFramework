<?php

/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 18.04.18
 * Time: 20:32
 */
require("vendor/autoload.php");

use \Angle\Engine\RouterEngine\Collection;
use \Angle\Engine\RouterEngine\Route;
use \Angle\Engine\RouterEngine\Router;


use Tracy\Debugger;

Debugger::enable(Debugger::DEBUG);
$engine = new \Angle\Engine\Template\Engine('views', ['appendix' => '?v=1.2.3']);

$router = new Collection();

define("APP_URL", __DIR__ . "/");
define("FILE_URL", __DIR__ . "/");

$router = new Router($router);
$route  = $router->matchCurrentRequest();

$engine->initSyntax();

$engine->render('views/test.tmp', []);