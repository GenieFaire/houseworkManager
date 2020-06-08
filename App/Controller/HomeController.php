<?php


namespace App\Controller;


use App\Repository\FamilyRepository;

class HomeController extends Controller
{

    public function index($param ="")
    {
        $this->render("home");
    }
}