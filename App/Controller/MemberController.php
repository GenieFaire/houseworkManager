<?php


namespace App\Controller;

use App\Repository\MemberRepository;
use App\Entity\Member;
use App\Repository\TaskRepository;
use App\Repository\TasktodoRepository;
use App\Services\MailService;


class MemberController extends Controller
{
    public function getList($idFamily)
    {
        $memberRepository = new MemberRepository();
        return $memberRepository->getAllMember($idFamily);
    }

    public function getMemberByPseudo(string $pseudo)
    {
        $memberRepository = new MemberRepository();
        $response = $memberRepository->getOneMember($pseudo);
        if ($response == false) {
            return false;
        } else {
            $member = new Member($response->idMember, $response->password, $response->birthday, $response->idFamily, $response->grade, $response->mail, $response->pseudo, $response->actived, $response->code);
            return $member;
        }
    }

    public function getMemberById(int $idMember)
    {
        $memberRepository = new MemberRepository();
        $response = $memberRepository->getOneMemberById($idMember);
        if ($response == false) {
            return false;
        } else {
            $member = new Member($response->idMember, $response->password, $response->birthday, $response->idFamily, $response->grade, $response->mail, $response->pseudo, $response->actived, $response->code);
            return $member;
        }
    }

    public function index($param)
    {

        // TODO voir l'utilité du cleaninput
        $param = $this->cleanInput($param);
        $this->checkSession();
        $this->generateView($param);
    }

    public function connexion(array $param)
    {
        $member = $this->getMemberByPseudo($param['pseudo']);

        if ($member === false) {
            header("Location: index.php?p=home&param=1");
        } else {
            if ($member->getActived() === true) {
                $verification = $this->checkPassword($member, $param);
                if ($verification === false) {
                    header("Location: index.php?p=home&param=1");
                } else {
                    $this->setSession($member->getPseudo(), $member->getIdFamily(), $member->getGrade(), $member->getIdMember());
                    $this->generateView($member->getIdMember());
                }
            } else {
                header("Location: index.php?p=home&param=4");
            }
        }
    }

    public function update(array $param)
    {
        $this->checkSession();

        $member = $this->getMemberById($param['idMember']);

        if (isset($param['birthday']) && $param['birthday'] != $member->getBirthday()) {
            $member->setBirthday($param['birthday']);
        }
        if (isset($param['grade']) && $param['grade'] != $member->getGrade()) {
            $member->setGrade($param['grade']);
        }
        if (isset($param['mail']) && $param['mail'] != $member->getMail()) {
            $member->setMail($param['mail']);
        }
        if (isset($param['pseudo']) && $param['pseudo'] != $member->getPseudo()) {
            $member->setPseudo($param['pseudo']);
        }
        if (isset($param['password']) && !password_verify($param['password'], $member->getPassword())) {
            $member->setPassword($param['password']);
        }
        $memberRepository = new MemberRepository();
        $memberRepository->update($member);

        if (isset($param['idFamily'])) {
            $members = $this->getList($param['idFamily']);
            $this->render("family", $members);
        } else {
            $this->render("member", $member);
        }
    }

    // change le mot de passe en bdd
    public function password(array $param)
    {
        $member = $this->getMemberById($param['idMember']);
        if ($member != false && $member->getCode() == $param['code']) {
            $member->setPassword($param['password']);
            $memberRepository = new MemberRepository();
            $response = $memberRepository->update($member);
            if ($response === true) {
                $memberRepository->activationAccount($param);
                $this->setSession($member->getPseudo(), $member->getIdFamily(), $member->getGrade(), $member->getIdMember());
                $this->generateView($param);
            }
        } else {
            header("Location: index.php?p=home&param=6");
        }
    }

    public function passwordPage(array $param)
    {
        $this->render("passwordPage", $param);
    }

    // TODO vérifier qu'on ne rentre pas deux pseudos identiques sinon on plante tout
    public function add(array $param)
    {
        $memberRepository = new MemberRepository();
        $this->checkSession();
        $param['code'] = $this->getRandNumber();
        $idMember = $memberRepository->addMember($param);

        $mail = new MailService();
        $mail->sendMail($param['mail'], $mail->passwordNewAccount($param['pseudo'], $param['code'], $idMember));

        header("Location: index.php?p=family");
    }

    public function delete(array $param)
    {
        $memberRepository = new MemberRepository();
        $this->checkSession();
        $memberRepository->deleteMember($param);
        header("Location: index.php?p=family");
    }

    public function disconnect()
    {
        $this->unsetSession();
        header("Location: index.php?p=home");
    }

    public function account(array $param)
    {
        $this->checkSession();
        $member = $this->getMemberByPseudo($_SESSION['pseudo']);
        $this->render("member", $member);
    }

    public function checkPassword(Member $member, array $param): bool
    {
        if (!password_verify($param['password'], $member->getPassword())) {
            return false;
        } else {
            if ($param['pseudo'] !== $member->getPseudo()) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function activation(array $param)
    {
        $member = $this->getMemberById($param['idMember']);
        $member->setCode(0);
        $member->setActived(1);

        $this->setSession($member->getPseudo(), $member->getIdFamily(), $member->getGrade(), $member->getIdMember());
        $memberRepository = new MemberRepository();
        $memberRepository->update($member);
        $this->generateView($param);
//        header("Location: index.php?p=tasktodo");
    }

    public function recoveryPassword(array $param)
    {
        $memberRepository = new MemberRepository();
        $member = $this->getMemberByPseudo($param['pseudo']);

        if ($member != false) {
            if ($member->getMail() != $param['mail']) {
                header("Location: index.php?p=home&param=3");
            } else {
                $member->setPassword("");
                $member->setActived(false);
                $member->setCode($this->getRandNumber());
                $memberRepository->update($member);
                $mail = new MailService();
                $mail->sendMail($member->getMail(), $mail->forgetPassword($member->getPseudo(), $member->getCode(), $member->getIdMember()));
                header("Location: index.php?p=home&param=2");
            }
        } else {
            header("Location: index.php?p=home&param=3");
        }
    }

    public function checkPseudo(array $param)
    {
        $memberRepository = new MemberRepository();
        $response = $memberRepository->uniquePseudo($param['pseudo']);
        echo $response['number'];
    }

    public function generateView(int $idMember)
    {

        $taskToDoRepository = new tasktodoRepository();
        $tasksToDo = $taskToDoRepository->getMemberTasksToDo($idMember);

        $datas['tasksToDo'] = $tasksToDo;

        if ($tasksToDo != false) {
            $datas['places'] = $this->getPlacesList();
            $datas['categories'] = $this->getCategoriesList();

            $taskRepository = new TaskRepository();

            $tasks = [];
            foreach ($tasksToDo as $tasktodo) {
                $idTask = $tasktodo->getIdTask();
                $task = $taskRepository->getOneTask($idTask);
                if ($task !== false) $tasks[] = $task;
                $datas['tasks'] = $tasks;
                $dates[] = $tasktodo->getDate();
            }
            $result = array_unique($dates);
            $datas['uniqueDates'] = $result;
        } else {
            $datas = null;
        }
        $this->render("dashboard", $datas);
    }
}