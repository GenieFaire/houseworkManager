<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\MemberRepository;
use App\Repository\PlaceRepository;
use Exception;

abstract class Controller
{

    protected $action;

    protected array $request;

    protected string $file;

    public function render($fileName, $datas = "")
    {
        $root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
        $file = $root . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . $fileName . ".php";
        if (file_exists($file)) {
            ob_start();

            if (isset($_SESSION['pseudo'])) {
                require $root . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "navBar.php";
            }
            $datas;
            require $file;

            $content = ob_get_clean();
            require $root . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "default.php";
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

    /**
     * @param int $idFamily
     * @return array
     */
    public function getAllMembers(int $idFamily): array
    {
        $memberRepository = new MemberRepository();
        return $memberRepository->getAllMember($idFamily);
    }

    // nettoyage des input utilisateurs

    /**
     * @param $datas
     * @return array
     */
    public function cleanInput($datas): array
    {
        foreach ($datas as $key => $value) {
            $datas[$key] = htmlentities($value);
        }
        return $datas;
    }

    /**
     * @return int
     */
    protected function getRandNumber(): int
    {
        return rand(1000000, 10000000);
    }

    /**
     * @param string $pseudo
     * @param int $idFamily
     * @param bool $grade
     * @param int $idMember
     */
    protected function setSession(string $pseudo, int $idFamily, bool $grade, int $idMember): void
    {
        session_start();

        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['idFamily'] = $idFamily;
        $_SESSION['grade'] = $grade;
        $_SESSION['idMember'] = $idMember;
    }

    /**
     *
     */
    protected function unsetSession(): void
    {
        session_start();
        $_SESSION["id"] = "-1";
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    /**
     *
     */
    protected function checkSession(): void
    {
        session_start();

        if (!isset($_SESSION['pseudo']) or !isset($_SESSION['idFamily'])) {
            header("Location: index.php?p=home");
        }
    }

    /**
     * @return array
     */
    protected function getPlacesList() :array
    {
        $placeRepository = new PlaceRepository();
        $places = $placeRepository->getAllPlace();
        return $places;
    }

    /**
     * @return array
     */
    protected function getCategoriesList() :array
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->getAllCategory();
        return $categories;
    }

    public abstract function index(array $param);

}

