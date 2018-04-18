<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 18.04.18
 * Time: 20:56
 */

namespace Angle\Engine\Template;


class Engine {

    protected $tokens;
    private $stream;

    public function getStream() {
        return $this->stream;
    }

    public function setStream($stream) {
        $this->stream = $stream;
    }

    private function compile($stream) {
        $this->setStream($stream);
        $this->tokens = new Syntax();
        foreach ($this->tokens->getTokens() as $token) {
            $this->stream = ($token['callback']) ? preg_replace_callback($token['pattern'], $token['replacement'], $this->getStream()) : preg_replace($token['pattern'], $token['replacement'], $this->getStream());
        }
    }

    public function render($view, $params = []) {
        if (!empty($params)) extract($params);

        $file = $this->compile(file_get_contents($view));

        ob_start();
        echo $file;
        $file = ob_get_clean();
        $this->display($file);
    }
    private function display($content) {
        echo $content;
    }
}