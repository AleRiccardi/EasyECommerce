<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 20/01/2018
 * Time: 13:40
 */

namespace Inc\Ajax;


class AjaxEngine {
    public function __construct() {
        $this->init();
    }

    protected function init() {
        if (isset($_POST['action']) && !empty($_POST['action'])) {
            $functionCalled = $_POST['action'];
            $functions = get_class_methods($this);
            foreach ($functions as $function) {
                if ($function == $functionCalled) {
                    echo $this->{$function}();
                }
            }
        }
    }

    protected function get($nameParam) {
        if (isset($_POST[$nameParam])) {
            return $_POST[$nameParam];
        }
    }

}