<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 20.04.18
 * Time: 15:43
 */

namespace Angle\Engine\Router;

use Fig\Http\Message\RequestMethodInterface;

class Route {

    private $url;

    private $methods = array(

        RequestMethodInterface::METHOD_GET,
        RequestMethodInterface::METHOD_POST,
        RequestMethodInterface::METHOD_PUT,
        RequestMethodInterface::METHOD_DELETE

    );

    private $name;

    private $target;

    private $filters = array();

    private $parameters = array();

    private $parametersByName;

    public function __construct($resource, array $config) {
        $this->url        = $resource;
        $this->config     = $config;
        $this->methods    = isset($config['methods']) ? (array) $config['methods'] : array();
        $this->target     = isset($config['target']) ? $config['target'] : null;
        $this->name       = isset($config['name']) ? $config['name'] : null;
        $this->parameters = isset($config['parameters']) ? $config['parameters'] : array();
    }
    public function getUrl() {
        return $this->url;
    }
    public function setUrl($url) {
        $url = (string)$url;
        // make sure that the URL is suffixed with a forward slash
        if (substr($url, -1) !== '/') {
            $url .= '/';
        }
        $this->url = $url;
    }
    public function getTarget() {
        return $this->target;
    }
    public function setTarget($target) {
        $this->target = $target;
    }
    public function getMethods() {
        return $this->methods;
    }
    public function setMethods(array $methods) {
        $this->methods = $methods;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = (string)$name;
    }
    public function setFilters(array $filters, $parametersByName = false) {
        $this->filters          = $filters;
        $this->parametersByName = $parametersByName;
        $this->validateFilters();
    }

    public function getRegex() {
        return preg_replace_callback('/(:\w+)/', array(&$this, 'substituteFilter'), $this->url);
    }

    private function substituteFilter($matches) {
        if (isset($matches[1], $this->filters[$matches[1]])) {
            return $this->filters[$matches[1]];
        }
        return '([\w-%]+)';
    }

    private function validateFilters() {
        foreach($this->filters as $key => $reg) {
            if(!preg_match('~^:([[a-z]])$~i', $key)) {
                throw new Exception('Invalid filter name `'.$key.'` it should contains only letters and start with `:`');
            }
        }
    }
    public function getParameters() {
        return $this->parameters;
    }
    public function setParameters(array $parameters) {
        $this->parameters = array_merge($this->parameters, $parameters);
    }
    public function dispatch() {
        $action = explode('::', $this->config['_controller']);
        if ($this->parametersByName) {
            $this->parameters = array($this->parameters);
        }
        $this->action = !empty($action[1]) && trim($action[1]) !== '' ? $action[1] : null;
        if (!is_null($this->action)) {
            $instance = new $action[0];
            call_user_func_array(array($instance, $this->action), $this->parameters);
        } else {
            $instance = new $action[0]($this->parameters);
        }
    }
    public function getAction() {
        return $this->action;
    }
}