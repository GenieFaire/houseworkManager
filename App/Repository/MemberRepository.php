<?php


namespace App\Repository;

use PDO;
use App\Entity\Member;

class MemberRepository extends Database
{

    public function getAllMember(int $idFamily): array
    {
        $members = [];
        $request = $this->connection->prepare("
                SELECT * FROM member
                    JOIN family ON member.idFamily = family.idFamily
                    WHERE member.idFamily = :idFamily");
        $request->bindValue(':idFamily', $idFamily, PDO::PARAM_INT);
        $request->execute();
        while ($datas = $request->fetch(PDO::FETCH_OBJ)) {
            $members[] = new Member($datas->idMember, $datas->password, $datas->birthday, $datas->idFamily, $datas->grade, $datas->mail, $datas->pseudo, $datas->actived, $datas->code);
        }
        return $members;
    }

    public function getOneMember(string $pseudo)
    {
        $request = $this->connection->prepare("
                SELECT * FROM member WHERE pseudo = :pseudo");
        $request->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $request->execute();

        $datas = $request->fetch(PDO::FETCH_OBJ);
        return $datas;
    }

    public function getOneMemberById(int $idMember)
    {
        $request = $this->connection->prepare("
                SELECT * FROM member WHERE idMember = :idMember");
        $request->bindValue(':idMember', $idMember, PDO::PARAM_INT);
        $request->execute();
        $datas = $request->fetch(PDO::FETCH_OBJ);
        return $datas;
    }

    /**
     * @param string $name
     * @param int $duration
     * @param int $age
     * @param int $periodicity
     * @param int $category
     * @param int $assignment
     * @param int $place
     * @return mixed
     */

    // TODO intégrer actived dans le tableau avant l'appel fonction et remplacer les ? par les noms
    public function addMember(array $param): int
    {
        $query = "INSERT INTO member(password, birthday, idFamily, grade, mail, pseudo, code) VALUES(:password, :birthday, :idFamily, :grade, :mail, :pseudo, :code)";
        $res = $this->connection->prepare($query);
        $res->bindValue(':password', password_hash($param['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $res->bindValue(':birthday', $param['birthday'], PDO::PARAM_STR);
        $res->bindValue(':idFamily', $param['idFamily'], PDO::PARAM_INT);
        $res->bindValue(':grade', $param['grade'], PDO::PARAM_BOOL);
        $res->bindValue(':mail', $param['mail'], PDO::PARAM_STR);
        $res->bindValue(':pseudo', $param['pseudo'], PDO::PARAM_STR);
        $res->bindValue(':code', $param['code'], PDO::PARAM_INT);
        $result = $res->execute();
        if ($result) {
            $member = $this->connection->lastInsertId();
        } else {
            echo 'le membre n\'a pas été enregistré';
        }
        return $member;
    }
// TODO y'as moyen de les concaténer ces deux-là ?
public function update(Member $member) {
    $query = "UPDATE member SET password = :password,  birthday = :birthday, grade = :grade, mail = :mail, pseudo = :pseudo, actived= :actived, code= :code WHERE idMember = :idMember";
    $res = $this->connection->prepare($query);
    $res->bindValue(':password', password_hash($member->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);
    $res->bindValue(':birthday', $member->getBirthday(), PDO::PARAM_STR);
    $res->bindValue(':grade', $member->getGrade(), PDO::PARAM_BOOL);
    $res->bindValue(':mail', $member->getMail(), PDO::PARAM_STR);
    $res->bindValue(':pseudo', $member->getPseudo(), PDO::PARAM_STR);
    $res->bindValue(':actived', $member->getActived(), PDO::PARAM_BOOL);
    $res->bindValue(':code', $member->getCode(), PDO::PARAM_INT);
    $res->bindValue(':idMember', $member->getIdMember(), PDO::PARAM_INT);
    $member = $res->execute();
    return $member;
}
    public function updateMember(array $param): bool
    {
        $query = "UPDATE member SET password = :password,  birthday = :birthday, grade = :grade, mail = :mail, pseudo = :pseudo WHERE idMember = :idMember";
        $res = $this->connection->prepare($query);
        $res->bindValue(':password', password_hash($param['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $res->bindValue(':birthday', $param['birthday'], PDO::PARAM_STR);
        $res->bindValue(':grade', $param['grade'], PDO::PARAM_BOOL);
        $res->bindValue(':mail', $param['mail'], PDO::PARAM_STR);
        $res->bindValue(':pseudo', $param['pseudo'], PDO::PARAM_STR);
        $res->bindValue(':idMember', $param['idMember'], PDO::PARAM_INT);
        $member = $res->execute();
        return $member;
    }

    public function updateSelf(array $param, int $id): bool
    {
        $query = "UPDATE member SET password = :password,  birthday = :birthday, mail = :mail, pseudo = :pseudo WHERE idMember = :idMember";
        $request = $this->connection->prepare($query);
        $request->bindValue(':password', password_hash($param['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $request->bindValue(':birthday', $param['birthday'], PDO::PARAM_STR);
        $request->bindValue(':mail', $param['mail'], PDO::PARAM_STR);
        $request->bindValue(':pseudo', $param['pseudo'], PDO::PARAM_STR);
        $request->bindValue(':idMember', $id, PDO::PARAM_INT);
        $member = $request->execute();
        return $member;
    }

    public function deleteMember(array $param): bool
    {
        $query = "DELETE FROM member WHERE idMember = ?";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idMember', $param['idMember'], PDO::PARAM_INT);
        $member = $request->execute();
        return $member;
    }

    public function activationAccount(array $param)
    {
        $query = "UPDATE member SET actived = 1,  code = 0 WHERE idMember = :idMember";
        $request = $this->connection->prepare($query);
        $request->bindValue(':idMember', $param['idMember'], PDO::PARAM_INT);
        $member = $request->execute();
        return $member;
    }


public function uniquePseudo(string $pseudo) {
    $query = "SELECT count(pseudo) as number FROM member WHERE pseudo = :pseudo";
    $request = $this->connection->prepare($query);
    $request->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $request->execute();
    $response = $request->fetch(PDO::FETCH_ASSOC);
    return $response;
}

}
//$_SESSION['id'] = $res['idUtilisateur'];
//setcookie("mdp", $res['motDePasse'], time()+6000);
//    // POUR GENERER LE HASH A LA CREATION DU COMPTE
//    //$reshash = password_hash($pass, PASSWORD_DEFAULT);
//
//
//
//}