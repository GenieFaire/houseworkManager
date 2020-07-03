<?php


namespace App\Controller;


use App\Repository\FamilyRepository;

class HomeController extends Controller
{

    /**
     * @param string $param
     * @throws \Exception
     */
    public function index($param ="") :void
    {
        $this->render("home");
    }
}