<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 20.04.18
 * Time: 15:43
 */

namespace Angle\Engine\RouterEngine;


class Collection extends \SplObjectStorage {

    public function attachRoute(Route $attach) {
        parent::attach($attach);
    }

    public function all() {
        $temp = array();
        foreach ($this as $route) {
            $temp[] = $route;
        }

        return $temp;
    }
}