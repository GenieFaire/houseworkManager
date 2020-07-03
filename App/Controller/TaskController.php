<?php


namespace App\Controller;

use App\Entity\Task;
use App\Repository\MemberRepository;
use App\Repository\TaskRepository;
use App\Repository\TasktodoRepository;
use App\Services\taskServices;

class TaskController extends Controller
{
    public function index(array $param) :void
    {
        $this->checkSession();
        $this->generateView($param);
    }

    public function getList() :array
    {
        $taskRepository = new TaskRepository();
        return $taskRepository->getAllTask($_SESSION['idFamily']);
    }

    public function update(array $param) :Task
    {
        $this->checkSession();
        $taskRepository = new TaskRepository();

        $datas = $taskRepository->updateTask($param);
        $task = new Task($datas->idTask, $datas->taskName, $datas->duration, $datas->minimumAge, $datas->periodicity, $datas->idCategory, $datas->idPlace, $datas->idFamily);
        return $task;
    }

    public function updateTask(array $param) :void
    {
        $this->checkSession();
        $taskRepository = new TaskRepository();
        $taskToDoRepository = new tasktodoRepository();

        //update de la tâche
        $taskRepository->updateTask($param);
        //récupération de la tâche
        $task = $taskRepository->getOneTask($param['idTask']);

        // assignation de la tâche ok
        $idMember = $this->assignmentTask($param, $task);

        if (isset($param['today']) && $param['today'] == 1) {
            $param['date'] = date('Y-m-d');

            $tasksToUpdate = $taskToDoRepository->getTasksToDoNotDone($param['idTask'], $param['date']);
            if($tasksToUpdate !=false)
            foreach ($tasksToUpdate as $taskToUpdate) {
                $taskToUpdate->setIdMember($idMember);
            }
        }

        //mise en base de la TaskToDo
        $this->addTaskToDoToDatabase($param, $taskToDoRepository, $idMember, $task);
        $this->generateView();
    }

    public function addTask(array $param) :void
    {
        $this->checkSession();
        $taskRepository = new TaskRepository();
        $taskToDoRepository = new tasktodoRepository();

        // Création de la task
        $param['idTask'] = $taskRepository->addTask($param, $_SESSION['idFamily']);

        //récupération de la tâche
        $task = $taskRepository->getOneTask($param['idTask']);

        // assignation de la tâche
        $idMember = $this->assignmentTask($param, $task);

        // vérification du champ date et ajout de la date du jour si pas définie par l'user
        if ($param['date'] == '') {
            $param['date'] = date('Y-m-d');
        }

        $this->addTaskToDoToDatabase($param, $taskToDoRepository, $idMember, $task);
        $this->generateView();
    }

    public function delete(array $param) :void
    {
        $this->checkSession();
        $taskRepository = new TaskRepository();
        $taskRepository->deleteTask($param['idTask']);
        $this->generateView();
    }

    /**
     * @param array|null $param
     * @throws \Exception
     */
    public function generateView(array $param = null) :void
    {
        $taskToDoRepository = new tasktodoRepository();

        $datas['places'] = $this->getPlacesList();
        $datas['categories'] = $this->getCategoriesList();

        $members = $this->getAllMembers($_SESSION['idFamily']);
        $datas['members'] = $members;

        if (isset($param['idTask']) && $param['idTask'] != "") {
            $taskRepository = new TaskRepository();
            $task = $taskRepository->getOneTask($param['idTask']);
            $datas['task'] = $task;
            $taskToDo = $taskToDoRepository->getOneTaskToDo($param['idTask']);
            $datas['taskToDo'] = $taskToDo;

            $this->render("task", $datas);
        } else {
            $tasks = $this->getList();
            if ($tasks != false) {
                foreach ($tasks as $task) {
                    $tasksToDo[] = $taskToDoRepository->getOneTaskToDo($task->getIdTask());
                }
                $datas['tasksToDo'] = $tasksToDo;
                $datas['tasks'] = $tasks;
            } else {
                $datas['tasksToDo'] = null;
            }
            $this->render("tasks", $datas);
        }
    }

    /**
     * @param array $param
     * @param Task $task
     * @return int
     */
    private function assignmentTask(array $param, Task $task): int
    {
        var_dump($param['idMember']);
        if ($param['idMember'] != 0) {
            $idAssignedMember = $param['idMember'];
        } else {
            $members = $this->getAllMembers($_SESSION['idFamily']);
            var_dump($members);
            $taskServices = new taskServices();
            $idAssignedMember = $taskServices->taskAssignment($task->getMinimumAge(), $members);
        }
        return $idAssignedMember;
    }

    /**
     * @param array $param
     * @param TaskToDoRepository $taskToDoRepository
     * @param int $idMember
     * @param Task $task
     */
    private function addTaskToDoToDatabase(array $param, TaskToDoRepository $taskToDoRepository, int $idMember, Task $task): void
    {
        $periodicity = $task->getPeriodicity();
        $assignmentDuring = $param['assignmentDuring'];

        for ($i = 0; $i < $assignmentDuring; $i += $periodicity) {
            $date = date('Y-m-d', strtotime($param['date'] . '+' . $i . 'days'));
            $taskToDoRepository->assignTaskToDo($task->getIdTask(), $idMember, $date);
        }
    }

    public function done(array $param) :void
    {
        $this->checkSession();
        $taskToDoRepository = new tasktodoRepository();
        $taskToDoRepository->doneTask((int)$param['idTask']);
        $this->generateView($param);
    }
}

