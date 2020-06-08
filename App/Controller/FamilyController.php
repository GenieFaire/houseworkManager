<?php


namespace App\Controller;


use App\Repository\FamilyRepository;
use App\Repository\MemberRepository;
use App\Services\MailService;

class FamilyController extends Controller
{
    /**
     * @param array $param
     */
    public function index(array $param) :void
    {
        $this->generateView();
    }

    public function addFamily(array $param): void
    {
        $familyRepository = new FamilyRepository();
        $param['idFamily'] = $familyRepository->addFamily($param['familyName']);
        $param['grade'] = 1;
        $param['code'] = $this->getRandNumber();


        $firstMember = new memberRepository();
        $idMember = $firstMember->addMember($param);

        $mail = new MailService();
        $mail->sendMail($param['mail'], $mail->activationMail($param['pseudo'], $param['code'], $idMember));
        header("Location: index.php?p=home&param=2");
    }

    public function update(array $param)
    {
        $familyRepository = new FamilyRepository();
        $familyRepository->updateFamily($param);
        $this->generateView();
    }

    public function delete(array $param)
    {
        $familyRepository = new FamilyRepository();
        $familyRepository->deleteFamily($param);
        $this->generateView();
    }

    public function generateView($action = "")
    {
        if ($action === 'add') {
            $memberRepository = new MemberRepository();
            $member = $memberRepository->getOneMember($_SESSION['pseudo']);
            $this->render("dashboard", $member);
        } else {
            $this->checkSession();
            $memberRepository = new MemberRepository();
            $members = $memberRepository->getAllMember($_SESSION['idFamily']);
            $this->render("family", $members);
        }
    }

    public function getList($familyMembers)
    {
        $memberRepository = new MemberRepository();
        $members = $memberRepository->getAllMember($familyMembers);
        return $members;
    }
}