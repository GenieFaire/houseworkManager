<?php

namespace App\Repository;

use App\Entity\TaskToDo;
use PDO;


class TasktodoRepository extends Database
{

    public function getTasksToDoNotDone(int $idTask)
    {
        $query = "SELECT * FROM tasktodo WHERE idTask = :idTask AND done = 0";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        $request->execute();
    }

    public function getMemberTasksToDo(int $idMember)
    {
        $tasksToDo = [];
        $query = "SELECT * FROM tasktodo WHERE idMember = :idMember AND done = 0 ORDER BY date";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idMember', $idMember, PDO::PARAM_INT);
        $request->execute();
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $taskToDo = new TaskToDo($datas->idTask, $datas->idMember, $datas->date, $datas->done);
            $tasksToDo[] = $taskToDo;
        }
        return $tasksToDo;
    }

    public function getOneTaskToDo(int $idTask)
    {
        $query = "SELECT * FROM tasktodo WHERE idTask = :idTask ORDER BY date DESC LIMIT 1";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        $request->execute();
        $datas = $request->fetch(PDO::FETCH_OBJ);
        $taskToDo = new TaskToDo($datas->idTask, $datas->idMember, $datas->date, $datas->done);
        return $taskToDo;
    }

    public function addTaskToDo(int $idTask, string $date): bool
    {
        $query = "INSERT INTO tasktodo(idTask, date, done) VALUES(:idTask, :date, 0)";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        $request->bindValue(':date', $date, PDO::PARAM_STR);
        $taskToDo = $request->execute();
        return $taskToDo;
    }

    public function assignTaskToDo(int $idTask, int $idMember, string $date)
    {
        $query = "INSERT INTO tasktodo(idTask, idMember, date, done) VALUES(:idTask, :idMember, :date, 0) ON DUPLICATE KEY UPDATE idMember= :idMember";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        $request->bindValue(':idMember', $idMember, PDO::PARAM_INT);
        $request->bindValue(':date', $date, PDO::PARAM_STR);
        $request->execute();
    }

    public function doneTask(int $idTask)
    {
        $query = "UPDATE tasktodo SET done = 1 WHERE idTask = :idTask";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idTask', $idTask, PDO::PARAM_INT);
        return $request->execute();
    }
}

