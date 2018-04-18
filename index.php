<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 18.04.18
 * Time: 20:32
 */
require("vendor/autoload.php");

$engine = new \Angle\Engine\Template\Engine();
$engine->render("views/test.tmp", [
    "test" => "Hello World"
]);