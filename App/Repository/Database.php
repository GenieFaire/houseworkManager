<?php

namespace App\Repository;

use PDO;
use PDOException;

// TODO factory
class Database
{

    protected PDO $connection;

    public function __construct()
    {
        try {
            if ($_SERVER['SERVER_NAME'] === 'localhost') {
                $this->connection = new PDO(
                    'mysql:host=localhost;dbname=housework_manager',
                    'housework',
                    'R7DUsmE_SmEGVY9',
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                );
            } else {
                $this->connection = new PDO(
                    'mysql:host=mysql-housework.alwaysdata.net;dbname=housework_manager',
                    'housework',
                    'R7DUsmE_SmEGVY9',
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                );
            }

//            var_dump($this->connection);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getDb()
    {
        if ($this->connection instanceof PDO) {

            return $this->connection;
        }
    }


//    /**
//     * @param $statement
//     * @param $className
//     * @return array returns an array of object depends on classname value
//     */
//    public static function getAll(string $statement, string $className): array
//    {
//        $res = self::getDb()->query($statement);
//        $res->setFetchMode(PDO::FETCH_CLASS, $className);
//        return $res->fetchAll();
//    }

    /**
     * @param $statement
     * @return mixed
     */
    //TODO create function getall by prepare and rename functions
    public function getOne($statement, $attributes, $className) //équalent de prepare pour gpha
    {
        $res = $this->getDb()->prepare($statement);
        $res->execute($attributes);
        return $res->setFetchMode(PDO::FETCH_CLASS, $className);
    }

//    public static function query($statement, $attributes = null)
//    {
//        if ($attributes) {
//            return App::getDb()->getOne($statement, $attributes, get_called_class());
//        } else {
//            return App::getDb()->getAll($statement, get_called_class());
//        }
//    }

}
