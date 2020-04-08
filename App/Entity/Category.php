<?php


namespace App\Entity;


use App\App;

class Category extends Table
{

    protected static $table = 'category';

//    public static function getAll()
//    {
//        return App::getDb()->query("
//                    SELECT *
//                    FROM " . self::$table
//            , __CLASS__);
//    }

    public function getUrl()
    {
        return 'index.php?p=categories&id=' . $this->idCategory;
    }
}