<?php


namespace App\Services;


use App\Entity\Member;
use App\Entity\Task;
use App\Entity\TaskToDo;

class taskServices
{

    public function dailyRepeat(Task $task, array $members) {
        $this->taskAssignement($task, $members);
        $assignedTask = new TaskToDo();
    }

    public function weeklyRepeat(Task $task, array $members)
    {

        // TODO ajouter la tâche à faire pour les 7 prochains jours
        $idMember = $this->taskAssignement($task, $members);
        $assignedTask = new TaskToDo($task->getIdTask(), $idMember, $member->getIdMember);

    }

    public function monthlyRepeat()
    {
        // TODo ajouter la tâche sur les prochains mois
    }



// TODO récupérer les tâches non assignées
// TODO retourne l'idMember choisi
    public function taskAssignement(Task $tasks, array $members)
    {
        foreach ($tasks as $task) {
        foreach ($members as $member) {
            $age = $this->memberAge($member);

        if ($age >= $task->getMinimumAge()) {
//            $random[$member->getIdMember()] = $age;
            $assignment[$task->getIdTask()] = $member->getIdMember();
            var_dump($assignment); // calcul age correct
        }
    }

            // Ne pas mettre trop de tâches à la même personne
        }
    }

    private
    function memberAge($member)
    {
        $memberBirthday = explode('-', $member->getBirthday());
        $date = explode('/', date('Y/m/d'));

        if (($memberBirthday[1] < $date[1]) || (($memberBirthday[1] == $date[1]) && ($memberBirthday[2] <= $date[2])))
            return $date[0] - $memberBirthday[0];

        return $date[0] - $memberBirthday[0] - 1;
    }


}

