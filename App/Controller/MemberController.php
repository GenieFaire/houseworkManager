<?php


namespace App\Controller;

use App\Repository\MemberRepository;
use App\Entity\Member;
use App\Repository\TaskRepository;
use App\Repository\TasktodoRepository;
use App\Services\MailService;


class MemberController extends Controller
{

    /**
     * @param string $pseudo
     * @return Member|bool
     */
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

    /**
     * @param int $idMember
     * @return Member|bool
     */
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

    /**
     * @param array $param
     */
    public function index($param) :void
    {
        $param = $this->cleanInput($param);
        $this->checkSession();
        $this->generateView($_SESSION['idMember']);
    }

    public function connexion(array $param) :void
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

    public function update(array $param) :void
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
            $members = $this->getAllMembers($param['idFamily']);
            $this->render("family", $members);
        } else {
            $this->render("member", $member);
        }
    }

    public function password(array $param) :void
    {
        $member = $this->getMemberById($param['idMember']);
        if ($member != false && $member->getCode() == $param['code']) {
            $member->setPassword($param['password']);
            $memberRepository = new MemberRepository();
            $response = $memberRepository->update($member);
            if ($response === true) {
                $memberRepository->activationAccount($param);
                $this->setSession($member->getPseudo(), $member->getIdFamily(), $member->getGrade(), $member->getIdMember());
                $this->generateView($member->getIdMember());
            }
        } else {
            header("Location: index.php?p=home&param=6");
        }
    }

    public function passwordPage(array $param) :void
    {
        $this->render("passwordPage", $param);
    }

    public function add(array $param) :void
    {
        $memberRepository = new MemberRepository();
        $this->checkSession();
        $param['code'] = $this->getRandNumber();
        $idMember = $memberRepository->addMember($param);

        $mail = new MailService();
        $mail->sendMail($param['mail'], $mail->passwordNewAccount($param['pseudo'], $param['code'], $idMember));

        header("Location: index.php?p=family");
    }

    public function delete(array $param) :void
    {
        $memberRepository = new MemberRepository();
        $this->checkSession();
        $memberRepository->deleteMember($param);
        header("Location: index.php?p=family");
    }

    public function disconnect() :void
    {
        $this->unsetSession();
        header("Location: index.php?p=home");
    }

    public function account(array $param) :void
    {
        $this->checkSession();
        $member = $this->getMemberByPseudo($_SESSION['pseudo']);
        $this->render("member", $member);
    }

    /**
     * @param Member $member
     * @param array $param
     * @return bool
     */
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

    public function activation(array $param) :void
    {
        $member = $this->getMemberById($param['idMember']);
        $member->setCode(0);
        $member->setActived(1);

        $this->setSession($member->getPseudo(), $member->getIdFamily(), $member->getGrade(), $member->getIdMember());
        $memberRepository = new MemberRepository();
        $memberRepository->update($member);
        $this->generateView($member->getIdMember());
    }


    public function recoveryPassword(array $param) :void
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

    public function checkPseudo(array $param) :void
    {
        $memberRepository = new MemberRepository();
        $response = $memberRepository->uniquePseudo($param['pseudo']);
        echo $response['number'];
    }

    public function generateView(int $idMember) :void
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
                if ($task !== false) {
                    $tasks[] = $task;

                }
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