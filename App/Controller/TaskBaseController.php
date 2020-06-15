<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\PlaceRepository;

class TaskBaseController extends Controller
{

    public function index(array $param)
    {
        $this->checkSession();
        $this->render("tasks", $datas);
    }

    protected function getPlacesList() {
        $placeRepository = new PlaceRepository();
        $places = $placeRepository->getAllPlace();
        return $places;
    }

    protected function getCategoriesList() {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->getAllCategory();
        return $categories;
    }
}