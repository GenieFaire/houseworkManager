<?php

namespace App\Entity;

class Task
{
    private int $_idTask;
    private string $_taskName;
    private int $_duration;
    private int $_minimumAge;
    private int $_periodicity;
    private int $_idCategory;
    private int $_idPlace;
    private int $_idFamily;

    public function __construct(int $id, string $name, int $duration, int $age, int $periodicity, int $idCategory, int $idPlace, int $idFamily)
    {
        $this->setIdTask($id);
        $this->setTaskName($name);
        $this->setDuration($duration);
        $this->setMinimumAge($age);
        $this->setPeriodicity($periodicity);
        $this->setIdCategory($idCategory);
        $this->setIdPlace($idPlace);
        $this->setIdFamily($idFamily);
    }

    /**
     * @return int
     */
    public function getIdFamily(): int
    {
        return $this->_idFamily;
    }

    /**
     * @param int $idFamily
     */
    public function setIdFamily(int $idFamily): void
    {
        $this->_idFamily = $idFamily;
    }



    /**
     * @return int
     */
    public function getMinimumAge() :int
    {
        return $this->_minimumAge;
    }

    /**
     * @param int $minimumAge
     */
    public function setMinimumAge(int $minimumAge): void
    {
        $this->_minimumAge = $minimumAge;
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
        $this->_idPlace = $idPlace;
    }

    /**
     * @return int
     */
    public function getIdTask() :int
    {
        return $this->_idTask;
    }

    /**
     * @param int $idTask
     */
    public function setIdTask(int $idTask): void
    {
        $id = (int)$idTask;
        if ($id > 0) {
            $this->_idTask = $idTask;
        }
    }

    /**
     * @return string
     */
    public function getTaskName() :string
    {
        return $this->_taskName;
    }

    /**
     * @param string $taskName
     */
    public function setTaskName(string $taskName): void
    {
        $this->_taskName = $taskName;
    }

    /**
     * @return int
     */
    public function getDuration() :int
    {
        return $this->_duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->_duration = $duration;
    }

    /**
     * @return int
     */
    public function getPeriodicity() :int
    {
        return $this->_periodicity;
    }

    /**
     * @param int $periodicity
     */
    public function setPeriodicity(int $periodicity): void
    {
        $this->_periodicity = $periodicity;
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
        $this->_idCategory = $idCategory;
    }
}