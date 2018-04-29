<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 18.04.18
 * Time: 20:32
 */
require("vendor/autoload.php");

use \Angle\Engine\Template\Engine;
use \Angle\Engine\Router\Collection;
use \Angle\Engine\Router\Route;
use \Angle\Engine\Router\Router;


use Tracy\Debugger;

Debugger::enable();

$engine = new Engine();

$router = new Collection();

$router->attachRoute(new Route('/id/:id', array(
    '_controller' => '\Angle\Examples\Controllers\User::display',
    'parameters' => ["engine" => $engine, 'id' => '\d+'],
    'methods' => 'GET'
)));

$router = new Router($router);
$route = $router->matchCurrentRequest();