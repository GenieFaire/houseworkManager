<?php
namespace App;

class Autoload {

    static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class) {

//        echo "DIRECTORY_SEPARATOR = " . DIRECTORY_SEPARATOR . "<br/>";
        $root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
//        echo "root = " . $root . "<br/>";
        $file = $root . str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
//        echo "file = " . $file . "<br/>";

        if (file_exists($file)) {
//            echo "exist" . "<br/>";
            require $file;
            return true;
        }
//        echo "n'existe pas" . "<br/>";
        return false;
    }
}
