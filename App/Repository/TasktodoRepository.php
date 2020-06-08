<?php

namespace App\Repository;

use App\Entity\TaskToDo;
use PDO;


class TasktodoRepository extends Database
{
    public function getNonAssignedTasksToDo(int $idFamily) {
        $tasksToDo = [];
        $query = "SELECT * FROM tasktodo WHERE idFamily = :idFamily AND idMember= 0 AND done=0";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idFamily', $idFamily, PDO::PARAM_INT);
        $request->execute();
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $taskToDo = new TaskToDo($datas->idTask, $datas->idMember, $datas->idFamily, $datas->date, $datas->done);
            $tasksToDo[] = $taskToDo;
        }
        return $tasksToDo;
    }

    public function getFamilyTasksToDo(int $idFamily): array
    {
        $tasksToDo = [];
        $query = "SELECT * FROM tasktodo WHERE idFamily = :idFamily";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idFamily', $idFamily, PDO::PARAM_INT);
        $request->execute();
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $taskToDo = new TaskToDo($datas->idTask, $datas->idMember, $datas->idFamily, $datas->date, $datas->done);
            $tasksToDo[] = $taskToDo;
        }
        return $tasksToDo;
    }

    public function getMemberTasksToDo(int $idMember)
    {
        $tasksToDo = [];
        $query = "SELECT * FROM tasktodo WHERE idMember = :idMember AND done = 0 ORDER BY date";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idMember', $idMember, PDO::PARAM_INT);
        $request->execute();
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $taskToDo = new TaskToDo($datas->idTask, $datas->idMember, $datas->idFamily, $datas->date, $datas->done);
            $tasksToDo[] = $taskToDo;
        }
        return $tasksToDo;
    }

    public function getOneTaskToDo(int $idTask)
    {
        $query = "SELECT * FROM tasktodo WHERE idTask = :idTask";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        $request->execute();
        $datas = $request->fetch(PDO::FETCH_OBJ);
        $datas = new TaskToDo($datas->idTask, $datas->idMember, $datas->idFamily, $datas->date, $datas->done);
        return $datas;
    }

    public function addTaskToDo(int $idFamily, int $idTask, string $date): bool
    {
        $query = "INSERT INTO tasktodo(idTask, idFamily, date) VALUES(:idTask, :idFamily, :date)";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idFamily', $idFamily, PDO::PARAM_INT);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        $request->bindValue(':date', $date, PDO::PARAM_STR);
        $taskToDo = $request->execute();
        return $taskToDo;
    }

    public function assignTaskToDo(array $param, int $idFamily): bool
    {
        $query = "UPDATE tasktodo SET idMember = :idMember WHERE idTask = :idTask AND idFamily = :idFamily";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idMember', $param['idMember'], PDO::PARAM_INT);
        $request->bindValue(':idTask', $param['idTask'], PDO::PARAM_INT);
        $request->bindValue(':idFamily', $idFamily, PDO::PARAM_INT);
        $task = $request->execute();
        return $task;
    }

//    public function deleteTaskToDo($param) {
//        $query = "DELETE FROM taskToDo WHERE idTask = :idTask";
//        $res = $this->db->prepare($query);
//        $res->bindValue(':idTask', $param, PDO::PARAM_INT);
//        $task = $res->execute();
//        return $task;
//    }

    public function doneTask(int $idTask)
    {
        $query = "UPDATE tasktodo SET done = 1 WHERE idTask = :idTask";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        return $request->execute();
    }
}

