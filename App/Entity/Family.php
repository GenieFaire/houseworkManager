<?php

namespace App\Entity;

class Family
{
    private int $_idFamily;
    private string $_familyName;

    /**
     * Family constructor.
     */
    public function __construct(int $id, string $familyName)
    {
        $this->setIdFamily($id);
        $this->setFamilyName($familyName);
    }

    /**
     * @return int
     */
    public function getIdFamily() :int
    {
        return $this->_idFamily;
    }

    /**
     * @param int $_idFamily
     */
    public function setIdFamily(int $idFamily): void
    {
        $id = (int)$idFamily;
        if ($id > 0) {
            $this->_idFamily = $idFamily;
        }
    }

    /**
     * @return string
     */
    public function getFamilyName() :string
    {
        return $this->_familyName;
    }

    /**
     * @param string $_familyName
     */
    public function setFamilyName(string $_familyName): void
    {
        $this->_familyName = $_familyName;
    }
}