<?php


namespace App\Controller;

use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Repository\PlaceRepository;
use App\Repository\TaskRepository;
use App\Repository\CategoryRepository;
use App\Repository\TaskToDoRepository;
use App\Services\taskServices;

class TaskController extends Controller
{

    public static function addNewTask(string $name, int $duration, int $age, int $periodicity, int $category, int $assignment, int $place): void
    {
        $taskRepository = new TaskRepository();
        $task = $taskRepository->addTask($name, $duration, $age, $periodicity, $category, $assignment, $place);

        if ($task === false) {
            echo 'La ligne na pas été rentrée';
        } else {
            echo 'Ligne rentrée avec succès';
        }
    }

    /**
     *
     */
    public function getList()
    {
        $taskRepository = new TaskRepository();
        return $taskRepository->getAllTask($_SESSION['idFamily']);
    }

    public function index(array $param)
    {

        $this->checkSession();
        $this->generateView($param);
//        $taskRepository = new TaskRepository();
//        $categoryRepository = new CategoryRepository();
//        $placeRepository = new PlaceRepository();
//        $memberRepository = new MemberRepository();
//        $taskToDoRepository = new tasktodoRepository();
//
//        $places = $placeRepository->getAllPlace();
//        $categories = $categoryRepository->getAllCategory();
//        $members = $memberRepository->getAllMember($_SESSION['idFamily']);
//
//
//        if (isset($param['action']) && $param['action'] === 'update') {
//            $taskRepository->updateTask($param);
//        } elseif (isset($param['action']) && $param['action'] === 'add') {
//        } elseif (isset($param['action']) && $param['action'] === 'delete') {
//        }
//        $assignmentTask = $taskToDoRepository->getAllTaskToDo($_SESSION['idFamily']);
//        $tasks = $this->getList();
//        $this->render("tasks", $tasks, $categories, $places, $members, $assignmentTask);
    }

    public function update(array $param) {
        $this->checkSession();
        $taskRepository = new TaskRepository();
        $taskToDo = new TaskToDoRepository();
        $checkTask = $taskToDo->getOneTaskToDo($param['idTask']);
        if($checkTask->getIdMember() != $param['idMember']) {
            $taskToDo->assignTaskToDo($param, $_SESSION['idFamily']);
        }
        $taskRepository->updateTask($param);
        $this->generateView();
    }

    public function addTask(array $param) {
        $this->checkSession();
        $taskRepository = new TaskRepository();
        $taskToDoRepository = new tasktodoRepository();
        $param['idTask'] = $taskRepository->addTask($param, $_SESSION['idFamily']);
//        $taskToDoRepository->addTaskToDo($_SESSION['idFamily'], $param['idTask'], $param['date']);
        if(isset($param['idMember']) && $param['idMember'] != "") {
            $taskToDoRepository->assignTaskToDo($param, $_SESSION['idFamily']);
        }

        $memberRepository = new MemberRepository();
        // récupérer les membres du plus jeune au plus vieu
        $members =$memberRepository->getAllMember($_SESSION['idFamily']);
        $tasks = $taskRepository->getAllTask($_SESSION['idFamily']);

//        $taskServices = new taskServices();
//        $taskServices->taskAssignement($tasks, $members);
        $this->generateView();
    }

    // TODO supprimer la taskToDO pas done
    public function delete(array $param) {
        $this->checkSession();
        $taskRepository = new TaskRepository();
        $taskRepository->deleteTask($param['idTask']);
        $this->generateView();
    }

    public function generateView(array $param = null) {
        $categoryRepository = new CategoryRepository();
        $placeRepository = new PlaceRepository();
        $memberRepository = new MemberRepository();
        $taskToDoRepository = new tasktodoRepository();

        $places = $placeRepository->getAllPlace();
        $datas['places'] = $places;
        $categories = $categoryRepository->getAllCategory();
        $datas['categories'] = $categories;
        $members = $memberRepository->getAllMember($_SESSION['idFamily']);
        $datas['members'] = $members;
        if (isset($param['idTask']) && $param['idTask'] != "") {
            $taskRepository = new TaskRepository();
            $task = $taskRepository->getOneTask($param['idTask']);
            $datas['task'] = $task;
            // TODO récupérer le dernier assignement où l'assignement à la date du jour ou le plus récent
            $taskToDo = $taskToDoRepository->getOneTaskToDo($param['idTask']);
            $datas['taskToDo'] = $taskToDo;
            $this->render("task", $datas);
        } else {
            $tasks = $this->getList($_SESSION['idFamily']);
            $datas['tasks'] = $tasks;
            $tasksToDo = $taskToDoRepository->getFamilyTasksToDo($_SESSION['idFamily']);
            $datas['tasksToDo'] = $tasksToDo;
            $this->render("tasks", $datas);
        }




    }
}

