<?php

namespace App\Controller;

use Exception;

class Router
{

    private $request;

    public function requestRoute()
    {
        try {
            $this->request = array_merge($_GET, $_POST);
            $controller = $this->createController();

            if (isset($this->request['action']) && $this->request['action'] != "") {
                $action = $this->request['action'];
                $controller->$action($this->request);
            } else {
                $controller->index($this->request);
            }
        } catch (Exception $e) {
            echo $e;
//            $this->gererErreur($e);
        }
    }

    private function createAction($controller)
    {
        $action = "";
        if (isset($this->request['action']) && $this->request['action'] != "") {
            $action = $this->request['action'];
        }
        if (method_exists($controller, $action)) {
            return $action;
        } else {
            throw new Exception("La méthode'$action' n'existe pas");
        }
    }

    private function createController()
    {
        $controllerName = "home";

        if (isset($this->request['p']) && $this->request['p'] != "") {
            $controllerName = $this->request['p'];
        }
        $controllerName = ucfirst(strtolower($controllerName));

        $controllerClass = "App\Controller\\" . $controllerName . "Controller";
//        echo "controllerClass = " . $controllerClass . "<br />";

        $controller = new $controllerClass();
        $controller->setRequest($this->request);
        return $controller;

//        $controllerFile = "..\\" . $controllerClass . ".php";
//        if (file_exists($controllerFile)) {
//            $controller = new $controllerClass();
//            $controller->setRequest($this->request);
//            return $controller;
//        } else {
////            throw new Exception("Fichier '$controllerFile' introuvable");
//
//        }
    }

    // gestion et affichage des erreurs
    private function gererErreur(Exception $exception)
    {
        //-------
    }
}
