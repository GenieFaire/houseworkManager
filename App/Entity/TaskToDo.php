<?php


namespace App\Entity;


class TaskToDo
{

    private int $_idTask;
    private int $_idMember;
    private string $_date;
    private bool $_done;
    private string $_assignmentValue;


    /**
     * TaskToDo constructor.
     * @param int $idMember
     * @param int $idTask
     * @param string $date
     * @param bool $done
     */
    public function __construct(int $idTask, int $idMember, string $date, bool $done)
    {
        $this->setIdTask($idTask);
        $this->setIdMember($idMember);
        $this->setDate($date);
        $this->setDone($done);
        $this->setDoneValue($done);
    }

    /**
     * @return int
     */
    public function getIdMember(): int
    {
        return $this->_idMember;
    }

    /**
     * @param int $idMember
     */
    public function setIdMember(int $idMember): void
    {
        $this->_idMember = $idMember;
    }

    /**
     * @return string
     */
    public function getDoneValue(): string
    {
        return $this->_assignmentValue;
    }

    /**
     * @param bool $done
     */
    public function setDoneValue(bool $done): void
    {
        if ($done == 0) {
            $this->_done = 'non effectuée';
        } elseif ($done == 1) {
            $this->_done = 'effectuée';
        }
    }

    /**
     * @return bool
     */
    public function getDone(): bool
    {
        return $this->_done;
    }

    /**
     * @param bool $done
     */
    public function setDone(bool $done): void
    {
        $this->_done = $done;
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
        $this->_idTask = $idTask;
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