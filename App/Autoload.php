<?php
namespace App;

class Autoload {

    static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class) {
        if (strpos($class, __NAMESPACE__ . '\\') === 0) {
            require  "..\\" . DIRECTORY_SEPARATOR. $class .'.php';
        }
    }
}
