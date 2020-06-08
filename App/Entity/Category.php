<?php

namespace App\Entity;

class Category
{
    private int $_idCategory;
    private string $_categoryName;

    /**
     * Category constructor.
     * @param $_idCategory
     * @param $_categoryName
     */
    public function __construct($idCategory, $categoryName)
    {
        $this->setIdCategory($idCategory);
        $this->setCategoryName($categoryName);
    }

    /**
     * @return int
     */
    public function getIdCategory() :int
    {
        return $this->_idCategory;
    }

    /**
     * @param int $idCategory
     */
    public function setIdCategory(int $idCategory): void
    {
        $id = (int)$idCategory;
        if ($id > 0) {
            $this->_idCategory = $idCategory;
        }
    }

    /**
     * @return string
     */
    public function getCategoryName() :string
    {
        return $this->_categoryName;
    }

    /**
     * @param string $_categoryName
     */
    public function setCategoryName(string $_categoryName): void
    {
        $this->_categoryName = $_categoryName;
    }
}