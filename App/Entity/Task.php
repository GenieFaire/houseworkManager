<?php

namespace App\Entity;

use App\App;


class Task extends Table
{
//    $idTask = 0;
//    $taskName = '';


//    public function __get($get)
//    {
//        $method = 'get' . ucfirst($get);
//        $this->$get = $this->$method();
//        return $this->$get;
//    }

    public static function getLast()
    {
        return self::getAll("
                SELECT idTask, taskName, duration, minimumAge, periodicity, toAssign, categoryName, placeName FROM task
                    JOIN category ON task.idCategory = category.idCategory 
                    join place p on task.idTask = p.idPlace
                    ", __CLASS__);
    }

    public function getUrl()
    {
        return 'index.php?p=single&id=' . $this->idTask;
    }
}