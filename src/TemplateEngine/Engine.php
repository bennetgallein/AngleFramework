<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 18.04.18
 * Time: 20:56
 */

namespace Angle\Engine\Template;

use org\bovigo\vfs\vfsStream;

class Engine {

    protected $tokens;
    private $stream;

    public function getStream() {
        return $this->stream;
    }

    public function setStream($stream) {
        $this->stream = $stream;
    }

    public function compile($stream) {
        $this->setStream($stream);
        $this->tokens = new Syntax();
        foreach ($this->tokens->getTokens() as $token) {
            $this->stream = ($token['callback']) ? preg_replace_callback($token['pattern'], $token['replacement'], $this->getStream()) : preg_replace($token['pattern'], $token['replacement'], $this->getStream());
        }
    }

    public function render($view, $params = []) {
        $params["app_url"] = APP_URL;
        $params['engine'] = $this;
        if (!empty($params)) extract($params);
        $viewArray = explode('/', $view);
        $viewPath = implode('/', $viewArray);

        vfsStream::setup($viewPath);

        $file = vfsStream::url($view . '.php');
        $this->compile(file_get_contents($view));

        file_put_contents($file, $this->getStream());

        ob_start();
        include $file;
        ob_end_flush();
    }
}