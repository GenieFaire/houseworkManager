<?php


namespace App\Controller;

use App\Entity\Member;
use App\Entity\Task;
use App\Entity\TaskToDo;
use App\Repository\CategoryRepository;
use App\Repository\MemberRepository;
use App\Repository\PlaceRepository;
use App\Repository\TaskRepository;
use App\Repository\TasktodoRepository;
use App\Services\taskServices;

class TasktodoController extends TaskBaseController
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
            $datas['places'] = $this->getPlacesList();
            $datas['categories'] = $this->getCategoriesList();

            $taskRepository = new TaskRepository();

            $tasks = [];
            foreach ($tasksToDo as $tasktodo) {
                $idTask = $tasktodo->getIdTask();
                $task = $taskRepository->getOneTask($idTask);
                if ($task !== false) $tasks[] = $task;
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

    public function updateTask(array $param)
    {
        $taskRepository = new TaskRepository();
        $taskRepository->updateTask($param);
    }

    public function assignmentTaskToDo(array $param)
    {
        $this->checkSession();
        $memberRepository = new MemberRepository();
        $members = $memberRepository->getAllMember($_SESSION['idFamily']);

        $taskRepository = new TaskRepository();

        // Mise à jour de la Task (période, durée, age, nom, ....
        $taskRepository->updateTask($param);


        $task = $taskRepository->getOneTask($param['idTask']);


        $taskToDoRepository = new TasktodoRepository();

        if ($param['idMember'] != "") {
            $idAssignedMember = $param['idMember'];
        } else {
            $taskServices = new taskServices();
            $idAssignedMember = $taskServices->taskAssignment($task->getMinimumAge(), $members);
        }

        $periodicity = $task->getPeriodicity(); // récurrence
        $assignmentDuring = $param['assignmentDuring']; // durée d'assignation

        //vérifier que c'est équitable
        for ($i = 0; $i < $assignmentDuring; $i += $periodicity) {
            $date = date('Y-m-d', strtotime($param['date'] . '+' . $i . 'days'));
//            var_dump($date);
            $taskToDoRepository->assignTaskToDo($task->getIdTask(), $idAssignedMember, $date);

        }
        header("Location:index.php?p=task");
    }
}
