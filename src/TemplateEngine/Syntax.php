<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 18.04.18
 * Time: 20:45
 */

namespace Angle\Engine\Template;


class Syntax {

    public $tokens = array();

    public function __construct() {
        $this->addRule('/<!-- :([\w\d]+) -->/', '<?= $$1 ?>');
        /*$this->addRule("{?:([\w\d]\+)( = .\*)}", "<?php $$1$2; ?>");
        $this->addRule("{ ?:([\w\d]\+) }", "<?= $$1; ?>");*/
    }

    public function addRule($pattern, $replacement) {
        if (is_callable($replacement)) {
            $this->tokens[] = ['pattern' => $pattern, 'replacement' => $replacement, 'callback' => true];
        } else {
            $this->tokens[] = ['pattern' => $pattern, 'replacement' => $replacement, 'callback' => false];
        }
    }

    public function getTokens() {
        return $this->tokens;
    }

}