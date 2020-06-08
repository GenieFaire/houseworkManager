<?php

namespace App\Repository;

use App\Entity\Family;
use PDO;


class FamilyRepository extends Database
{

    public function addFamily(string $familyName) :int
    {
        $query = "INSERT INTO family(familyName) VALUES(:name)";
        $request = $this->connection->prepare($query);
        $request->bindValue(':name', $familyName, PDO::PARAM_STR);
        $request->execute();
        $family = $this->connection->lastInsertId();
        return $family;
    }

    public function updateFamily(array $param)
    {
        $query = "UPDATE family SET familyName = :name WHERE idFamily = :id";
        $request = $this->connection->prepare($query);
        $request->bindValue(':name', $param['familyName'], PDO::PARAM_STR);
        $request->bindValue(':id', $param['idFamily'], PDO::PARAM_INT);
        $family = $request->execute();
        return $family;
    }

    public function deleteFamily(array $param)
    {
        $query = "DELETE FROM family WHERE idFamily = :id";
        $request = $this->connection->prepare($query);
        $request->bindValue(':id', $param['idFamily'], PDO::PARAM_INT);
        return $request->execute();
    }
}