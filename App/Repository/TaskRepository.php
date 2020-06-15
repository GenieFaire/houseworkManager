<?php

namespace App\Repository;

use App\Entity\Task;
use PDO;

class TaskRepository extends Database
{

    public function getAllTask(int $idFamily)
    {
        $tasks = [];
        $query = "SELECT * FROM task WHERE idFamily = :idFamily";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idFamily', $idFamily, PDO::PARAM_INT);
        $request->execute();
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $task = new Task($datas->idTask, $datas->taskName, $datas->duration, $datas->minimumAge, $datas->periodicity, $datas->idCategory, $datas->idPlace, $datas->idFamily);
            $tasks[] = $task;
        }
        return $tasks;
    }

    /**
     * Return task of false if not exists
     * @param int $id
     * @return Task|bool
     */
    public function getOneTask(int $id)
    {
        $request = $this->connection->prepare("
                SELECT * FROM task
                    WHERE idTask = :idTask  ");
        $request->bindValue(':idTask', $id, PDO::PARAM_INT);
        $request->execute();
        $row = $request->fetch(PDO::FETCH_OBJ);
        if ($row !== false) {
            return new Task(
                $row->idTask,
                $row->taskName,
                $row->duration,
                $row->minimumAge,
                $row->periodicity,
                $row->idCategory,
                $row->idPlace,
                $row->idFamily
            );
        }
        return false;
    }

    /**
     * @param string $name
     * @param int $duration
     * @param int $age
     * @param int $periodicity
     * @param int $category
     * @param int $assignment
     * @param int $place
     * @return mixed
     */
    public function addTask($param, $idFamily)
    {
        $query = "INSERT INTO task(taskName, duration, minimumAge, periodicity, idPlace, idCategory, idFamily) VALUES(:taskName, :duration, :minimumAge, :periodicity, :idPlace, :idCategory, :idFamily)";
        $res = $this->connection->prepare($query);
        $res->bindValue(':taskName', $param['taskName'], PDO::PARAM_STR);
        $res->bindValue(':duration', $param['duration'], PDO::PARAM_INT);
        $res->bindValue(':minimumAge', $param['minimumAge'], PDO::PARAM_INT);
        $res->bindValue(':periodicity', $param['periodicity'], PDO::PARAM_INT);
        $res->bindValue(':idPlace', $param['idPlace'], PDO::PARAM_INT);
        $res->bindValue(':idCategory', $param['idCategory'], PDO::PARAM_INT);
        $res->bindValue(':idFamily', $idFamily, PDO::PARAM_INT);
        $res->execute();
        $task = $this->connection->lastInsertId();
        return $task;
    }

    public function updateTask($param) {
        $query = "UPDATE task SET taskName = ?, duration = ?, minimumAge = ?, periodicity = ?, idPlace = ?, idCategory = ? WHERE idTask = ?";
        $request = $this->connection->prepare($query);
        $datas = $request->execute(array($param['taskName'], $param['duration'], $param['minimumAge'], $param['periodicity'], $param['idPlace'], $param['category'], $param['idTask']));
        return $datas;
    }

    public function deleteTask($param) {
        $query = "DELETE FROM task WHERE idTask = :idTask";
        $res = $this->connection->prepare($query);
        $res->bindValue(':idTask', $param, PDO::PARAM_INT);
        $task = $res->execute();
        return $task;
    }
}
