<?php

namespace App\Controller;


use Exception;

abstract class Controller
{

    // Action à réaliser
    protected $action;

    // Requête entrante
    protected array $request;

    protected string $file;

    // TODO arranger le render qui va nous péter à la gueule
    public function render($fileName, $datas = "", $categories = "", $places = "", $members ="", $tasksToDo = "")
    {
        $file = "..\\App\\Views\\" . $fileName . ".php";
        if (file_exists($file)) {
            ob_start();
            // TODO remplacer par si la session n'est pas active
            if (!strpos($file, 'home')) {
                require "..\\App\\Views\\templates\\navBar.php";
            }
            $members;
            $categories;
            $places;
            $tasksToDo;
            $datas;
            require $file;

            $content = ob_get_clean();
            require "..\\App\\Views\\templates\\default.php";
            return $content;
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }

    // Mémorisation de la requête entrante
    public function setRequest($request)
    {
        $this->request = $request;
    }

    // Action à réaliser.
    public function getAll()
    {
        //..
    }

    public function cleanInput($datas): array
    {
        foreach ($datas as $key => $value) {
            $datas[$key] = htmlentities($value);
        }
        return $datas;
    }

    protected function getRandNumber(): int
    {
        return rand(1000000, 10000000);
    }

    protected function setSession(string $pseudo, int $idFamily, bool $grade, int $idMember)
    {
        session_start();

        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['idFamily'] = $idFamily;
        $_SESSION['grade'] = $grade;
        $_SESSION['idMember'] = $idMember;
    }

    protected function unsetSession(): void
    {
        session_start();
        $_SESSION["id"] = "-1";
        session_unset();
        session_destroy();
//        setcookie("mdp","--", time()-1);
        header("Location: index.php");
    }

    protected function checkSession(): void
    {
        session_start();

        // si pas connecté, redirection page d'accueil
        if (!isset($_SESSION['pseudo']) or !isset($_SESSION['idFamily'])) {
            header("Location: index.php?p=home");
        }
    }



    public abstract function index(array $param);

}

