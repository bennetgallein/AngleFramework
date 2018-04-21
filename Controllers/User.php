<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 20.04.18
 * Time: 16:04
 */

namespace Angle\Examples\Controllers;


class User {

    public static function display($engine)  {
        $engine->render("views/test.tmp", [
            "test" => "Hello World",
            "posts" => [
                "test1" => "hi",
                "test2" => "hi2",
                "test3" => "hi3"
            ]
        ]);
    }

}