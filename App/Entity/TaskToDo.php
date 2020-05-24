<?php


namespace App\Entity;


class TaskToDo
{

    private int $_idFamily;
    private int $id_member;
    private int $_idTask;
    private string $_date;
    private string $_assignmentValue;
    private bool $_toAssign;

    /**
     * TaskToDo constructor.
     * @param int $idFamily
     * @param int $idMember
     * @param int $idTask
     * @param string $date
     * @param bool $toAssign
     */
    public function __construct(int $idFamily, int $idMember, int $idTask, string $date, bool $toAssign)
    {
        $this->setIdFamily($idFamily);
        $this->setIdMember($idMember);
        $this->setIdTask($idTask);
        $this->setDate($date);
        $this->setToAssign($toAssign);
        $this->setAssignmentValue($toAssign);
    }

    /**
     * @return int
     */
    public function getIdMember(): int
    {
        return $this->id_member;
    }

    /**
     * @param int $idMember
     */
    public function setIdMember(int $idMember): void
    {
        $this->id_member = $idMember;
    }

    /**
     * @return string
     */
    public function getAssignmentValue(): string
    {
        return $this->_assignmentValue;
    }

    /**
     * @param bool $toAssign
     */
    public function setAssignmentValue(bool $toAssign): void
    {
        if ($toAssign == 0) {
            $this->_assignmentValue = 'non';
        } elseif ($toAssign == 1) {
            $this->_assignmentValue = 'oui';
        }
    }

    /**
     * @return bool
     */
    public function getToAssign(): bool
    {
        return $this->_toAssign;
    }

    /**
     * @param bool $toAssign
     */
    public function setToAssign(bool $toAssign): void
    {
        $this->_toAssign = $toAssign;
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
    public function getIdTask(): int
    {
        return $this->_idTask;
    }

    /**
     * @param int $idTask
     */
    public function setIdTask(int $idTask): void
    {
        $this->idTask = $idTask;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->_date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->_date = $date;
    }
}