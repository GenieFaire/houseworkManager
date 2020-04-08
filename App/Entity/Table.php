<?php

namespace App\Entity;

use App\App;

class Table
{

    protected static $table;

    private static function getTable()
    {
        if (static::$table === null) {
            $className = explode('\\', get_called_class());
            static::$table = strtolower(end($className));
        }
        return static::$table;
    }

//    public static function find($id) { // fonction sensée récupérer un élément en fonction de son id
//        return App::getDb()->prepare("
//                    SELECT *
//                    FROM " . static::getTable() ."
//                    WHERE id=" .$id
//            , get_called_class());
//    }

    public static function query($statement, $attributes = null)
    {
        if ($attributes) {
            return App::getDb()->getOne($statement, $attributes, get_called_class());
        } else {
            return App::getDb()->getAll($statement, get_called_class());
        }
    }

    public static function all()
    {
        return App::getDb()->getAll("
                    SELECT * 
                    FROM " . static::getTable()
            , get_called_class());
    }

}
