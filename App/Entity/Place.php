<?php

namespace App\Entity;

class Place
{
    private int $_idPlace;
    private string $_placeName;

    /**
     * Place constructor.
     * @param int $idPlace
     * @param string $placeName
     */
    public function __construct(int $idPlace, string $placeName)
    {
        $this->_idPlace = $idPlace;
        $this->_placeName = $placeName;
    }

    /**
     * @return int
     */
    public function getIdPlace() :int
    {
            return $this->_idPlace;
    }

    /**
     * @param int $idPlace
     */
    public function setIdPlace(int $idPlace): void
    {
        $id = $idPlace;
        if ($id > 0) {
            $this->_idPlace = $idPlace;
        }
    }

    /**
     * @return string
     */
    public function getPlaceName() :string
    {
        return $this->_placeName;
    }

    /**
     * @param string $placeName
     */
    public function setPlaceName(string $placeName): void
    {
        $this->_placeName = $placeName;
    }
}