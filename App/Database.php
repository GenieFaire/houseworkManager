<?php

namespace App;

use mysql_xdevapi\Statement;
use PDO;

class Database {

    private $dbName;
    private $dbUser;
    private $dbPass;
    private $dbHost;
    private $pdo;

    public function __construct($dbName, $dbUser = 'root', $dbPass = '', $dbHost = 'localhost')
    {
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbHost = $dbHost;
    }

    private function getPDO() {
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:host=localhost;dbname=housework_manager', 'root', '');
            $pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    /**
     * @param $statement
     * @param $className
     * @return array returns an array of object depends on classname value
     */
    //TODO rename with query et create a fonction to get one by query
    // TODO replace fetchall by setfetchstyle
    public function getAll(string $statement, string $className): array
    {
        $res = $this->getPDO()->query($statement);
        $res->setFetchMode(PDO::FETCH_CLASS , $className);
        return $res->fetchAll();
    }

    /**
     * @param $statement
     * @return mixed
     */
    //TODO create function getall by prepare and rename functions
    public function getOne($statement, $attributes, $className) //équalent de prepare pour gpha
    {
        $res = $this->getPDO()->prepare($statement);
        $res->execute($attributes);
        return $res->setFetchMode(PDO::FETCH_CLASS, $className);
    }

}
