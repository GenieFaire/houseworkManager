<?php


namespace App\Controller;

use App\Entity\Member;
use App\Repository\CategoryRepository;
use App\Repository\MemberRepository;
use App\Repository\PlaceRepository;
use App\Repository\TaskRepository;
use App\Repository\TasktodoRepository;
use App\Services\taskServices;

class TasktodoController extends Controller
{
    public function index($param = "")
    {
        $this->checkSession();
        $this->generateView($param);
    }

    public function done(array $param)
    {
        $this->checkSession();
        $taskToDoRepository = new tasktodoRepository();
        $taskToDoRepository->doneTask((int)$param['idTask']);
        $this->generateView($param);
    }


    public function generateView($action = "")
    {

        $taskToDoRepository = new tasktodoRepository();
        $tasksToDo = $taskToDoRepository->getMemberTasksToDo($_SESSION['idMember']);
        $datas['tasksToDo'] = $tasksToDo;

        if ($tasksToDo != false) {
            $categoryRepository = new CategoryRepository();
            $placeRepository = new PlaceRepository();
            $taskRepository = new TaskRepository();

            $places = $placeRepository->getAllPlace();
            $datas['places'] = $places;

            $categories = $categoryRepository->getAllCategory();
            $datas['categories'] = $categories;

            foreach ($tasksToDo as $tasktodo) {
                $idTask = $tasktodo->getIdTask();
                $tasks[] = $taskRepository->getOneTask($idTask);
                $datas['tasks'] = $tasks;
                $dates[] = $tasktodo->getDate();
            }
            $result = array_unique($dates);
            $datas['uniqueDates'] = $result;
        } else {
            $datas = null;
            }
        $this->render("dashboard", $datas);
        }

        public function assignmentPage() {

        $this->checkSession();
        $taskToDoRepository = new TasktodoRepository();
        $result = $taskToDoRepository->getNonAssignedTasksToDo($_SESSION['idFamily']);
            $datas['tasksToDo'] = $result;
        $tasks = new TaskRepository();
        foreach ($result as $taskToAssign) {
            $res[] = $tasks->getOneTask($taskToAssign->getIdTask());
            $datas['tasks'] = $res;
        }

        $places = new PlaceRepository();
        $datas['places'] = $places->getAllPlace();
//        var_dump($datas);
            $this->render("assignment", $datas);

//        $members = new MemberRepository();
//        $members->getAllMember($_SESSION['idFamily']);
            // récupère les membres
            //affiche assignment.php
        }

        public function assignmentTaskToDo(array $param) {
        $this->checkSession();
            $members = new MemberRepository();
        $members->getAllMember($_SESSION['idFamily']);

            $tasks = new TaskRepository();
            $task = $tasks->getOneTask($param['idTask']);

        $taskServices = new taskServices();
        $toAssign = $taskServices->taskAssignement($task, $members);

            //vérifier que c'est équitable

//            rentrer la tâche à faire en bdd en fonction de la récurrence (tous les jours, les semaines, ...) et en fonction de la durée d'assignation
            $periodicity = $task->getPeriodicity();
            $assignmentDuring = $param['assignmentDuring'];
            if($assignmentDuring === 1) {
                //ajout dans la bdd une fois pour cette personne sans changer la date
                // si periodicity > 1
                // ajout une fois de plus sans assignement
            } elseif ($assignmentDuring >= 7) {
                // ajouter dans la base de données autant de fois que la période
                $i = 0;
                while ($i<=$assignmentDuring) {
                    $taskRepository->addAssignedTask($idTask, $i, $date);
                    $i += $periodicity;
                }
                 $taskRepository->addTaskNonAssigned(idTask, date, idFamily, $i+periodicity);
            }
            // calculer les dates dans la bdd
            // renvoyer la tâche à bien été ajoutée à membre jusqu'au date
        }
    }
