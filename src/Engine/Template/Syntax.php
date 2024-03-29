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
    private $additions = [];

    private $viewsFolder;

    public function __construct($viewsFolder, $additions = []) {
        $this->viewsFolder = $viewsFolder;
        $this->additions   = $additions;
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

    public function setViewsFolder($viewsFolderNew) {
        $this->viewsFolder = $viewsFolderNew;
    }

    public function getViewsFolder() {
        return $this->viewsFolder;
    }
    public function addToAdditions($a) {
        $this->additions = array_merge($this->additions, $a);
    }

    public function initSyntax() {
        // { :var = x }
        // {:var} & { :var }
        $this->addRule("/{ :([\w\d]+) }/", "<?= $$1; ?>");
        $this->addRule("/{:([\w\d]+)}/", "<?= $$1; ?>");

        // {foreach :entry in :list} & { foreach :entry in :list } & { foreach :entry in :list with :key }
        $this->addRule("/{ foreach :([\w\d]+) in :([\w\d]+) }/", "<?php foreach ($$2 as $$1): ?>");
        $this->addRule("/{foreach :([\w\d]+) in :([\w\d]+)}/", "<?php foreach ($$2 as $$1): ?>");
        $this->addRule("/{ foreach :([\w\d]+) in :([\w\d]+) with :([\w\d]+) }/", "<?php foreach ($$2 as $$3 => $$1): ?>");

        // { else }
        $this->addRule("/{ else }/", "<?php else: ?>");
        $this->addRule("/{else}/", "<?php else: ?>");

        // { if }
        $this->addRule("/{ if :([\w\d]+) }/", "<?php if ($$1): ?>");
        $this->addRule("/{if :([\w\d]+)}/", "<?php if ($$1): ?>");

        // { if (:var == x) }
        $this->addRule("/{ if \(:([\w\d]+) == ([\w\d]+)\) }/", "<?php if ($$1 == $2): ?>");

        // { if (:var.x == x) }
        $this->addRule("/{ if \(:([\w\d]+).([\w\d]+) == ([\w\d]+)\) }/", "<?php if ($$1['$2'] == $3): ?>");

        // { if (:var == :var) }
        $this->addRule("/{ if \(:([\w\d]+) == :([\w\d]+)\) }/", "<?php if ($$1 == $$2): ?>");

        // { endif }
        $this->addRule("/{endif}/", "<?php endif; ?>");
        $this->addRule("/{ endif }/", "<?php endif; ?>");

        // {endforeach} & { endforeach }
        $this->addRule("/{ endforeach }/", "<?php endforeach; ?>");
        $this->addRule("/{endforeach}/", "<?php endforeach; ?>");

        // { :list.point } & {:list.point}
        $this->addRule('/{ :([\w\d]+).([\w\d]+) }/', '<?php echo $$1["$2"]; ?>');

        // { include("file") }
        $this->addRule('/({ include\("(.*)"\) })/', '<?php $engine->render("$2"); ?>');
        $this->addRule('/({ include_raw\("(.*)"\) })/', '<?php include("$2"); ?>');

        // { css /url/ist/genau/hier.css }
        $this->addRule('/({ css (.*) })/', '<link rel="stylesheet" href="<?php echo APP_URL; ?>' . $this->viewsFolder . '/$2' . ($this->additions['appendix'] ?? '') . '" />');

        // { js /url/to/script.js }
        $this->addRule('/({ js (.*) })/', '<script src="<?php echo APP_URL; ?>' . $this->viewsFolder . '/$2' . ($this->additions['appendix'] ?? '') . '"></script>');

    }
}
