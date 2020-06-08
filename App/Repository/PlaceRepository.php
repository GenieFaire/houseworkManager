<?php

namespace App\Repository;

use App\Entity\Place;
use PDO;

class PlaceRepository extends Database
{

    public function getAllPlace() :array
    {
        $places = [];
        $request = $this->connection->query("SELECT * FROM place");
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $place = new Place($datas->idPlace, $datas->placeName);
            $places[] = $place;
        }
        return $places;
    }
}

