<?php

namespace App\Repository;

use App\Entity\Category;
use PDO;

class CategoryRepository extends Database
{

    public function getAllCategory() :array
    {
        $categories = [];
        $query = "SELECT * FROM category";
        $request = $this->connection->prepare($query);
        $request->execute();
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $category = new Category($datas->idCategory, $datas->categoryName);
            $categories[] = $category;
        }
        return $categories;
    }
}
