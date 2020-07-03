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

    /**
     * @param array $param
     */
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

    /**
     * @param array $param
     */
    public function update(array $param) :void
    {
        $familyRepository = new FamilyRepository();
        $familyRepository->updateFamily($param);
        $this->generateView();
    }

    /**
     * @param array $param
     */
    public function delete(array $param) :void
    {
        $familyRepository = new FamilyRepository();
        $familyRepository->deleteFamily($param);
        $this->generateView();
    }

    /**
     * @param string $action
     * @throws \Exception
     */
    public function generateView(string $action = "") :void
    {
        if ($action === 'add') {
            $memberRepository = new MemberRepository();
            $member = $memberRepository->getOneMember($_SESSION['pseudo']);
            $this->render("dashboard", $member);
        } else {
            $this->checkSession();
            $members = $this->getAllMembers($_SESSION['idFamily']);
            $this->render("family", $members);
        }
    }

}