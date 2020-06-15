<?php


namespace App\Services;


use App\Entity\Member;
use App\Entity\Task;
use App\Entity\TaskToDo;

class taskServices
{

    public function setCurrentDate()
    {
        return date("Y-m-d");
    }

    public function taskAssignment(int $minimumAge, array $members): int
    {
        shuffle($members);
        foreach ($members as $member) {
            $age = $this->memberAge($member);
            if ($age >= $minimumAge) {
                return $member->getIdMember();
                break;
            }
        }
    }

    private function memberAge($member)
    {
        $memberBirthday = explode('-', $member->getBirthday());
        $date = explode('/', date('Y/m/d'));

        if (($memberBirthday[1] < $date[1]) || (($memberBirthday[1] == $date[1]) && ($memberBirthday[2] <= $date[2])))
            return $date[0] - $memberBirthday[0];

        return $date[0] - $memberBirthday[0] - 1;
    }


}

