<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 20.04.18
 * Time: 16:04
 */

namespace Angle\Examples\Controllers;


use Angle\Engine\Template\Engine;

class User {

    public static function display(Engine $engine)  {
        $a = $engine->compile("views/test.tmp", [
            "test" => true,
            "posts" => [
                "test1" => "hi1",
                "test2" => "hi2",
                "test3" => "hi3"
            ]
        ]);
        dumpe($a);
    }

}