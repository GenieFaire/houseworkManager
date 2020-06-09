<?php

namespace App\Entity;

// TODO rajouter actived et code dans l'entité
class Member
{
    private int $_idMember;
    private string $_password;
    private string $_birthday;
    private int $_idFamily;
    private int $_grade;
    private string $_mail;
    private string $_pseudo;
    private bool $_actived;
    private int $_code;

    /**
     * Member constructor.
     * @param int $idMember
     * @param string $password
     * @param string $birthday
     * @param int $idFamily
     * @param bool $grade
     * @param string $mail
     * @param string $pseudo
     * @param bool $actived
     * @param int $code
     */
    public function __construct(int $idMember, string $password,  string $birthday, int $idFamily, bool $grade, string $mail, string $pseudo, bool $actived, int $code)
    {
        $this->setIdMember($idMember);
        $this->setPassword($password);
        $this->setBirthday($birthday);
        $this->setIdFamily($idFamily);
        $this->setGrade($grade);
        $this->setMail($mail);
        $this->setPseudo($pseudo);
        $this->setActived($actived);
        $this->setCode($code);
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->_code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->_code = $code;
    }

    /**
     * @return bool
     */
    public function getActived(): bool
    {
        return $this->_actived;
    }

    /**
     * @param bool $actived
     */
    public function setActived(bool $actived): void
    {
        $this->_actived = $actived;
    }

    /**
     * @return string
     */
    public function getMail() :string
    {
        return $this->_mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->_mail = $mail;
    }

    /**
     * @return int
     */
    public function getIdMember() :int
    {
        return $this->_idMember;
    }

    /**
     * @param int $idMember
     */
    public function setIdMember(int $idMember): void
    {
        $id = $idMember;
        if ($id > 0) {
            $this->_idMember = $idMember;
        }
    }

    /**
     * @return string
     */
    public function getPassword() :string
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getBirthday() :string
    {
        return $this->_birthday;
    }

    /**
     * @param string $birthday
     */
    public function setBirthday(string $birthday): void
    {
        $this->_birthday = $birthday;
    }

    /**
     * @return int
     */
    public function getIdFamily() :int
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
     * @return bool
     */
    public function getGrade() :bool
    {
        return $this->_grade;
    }

    /**
     * @param bool $grade
     */
    public function setGrade(bool $grade): void
    {
        $this->_grade = $grade;
    }

    /**
     * @return string
     */
    public function getPseudo() :string
    {
        return $this->_pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(string $pseudo): void
    {
        $this->_pseudo = $pseudo;
    }
}