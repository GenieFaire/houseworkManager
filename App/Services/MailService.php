<?php

namespace App\Services;

class MailService {

    public function activationMail(string $pseudo, int $code, int  $idMember)
    {
        $mailDatas = [];
        $mailDatas['sujet'] = "Activer votre compte";
        $mailDatas['entete'] = "From: housework@alwaysdata.net";


        $mailDatas['message'] = 'Bienvenue sur le Housework-manager,
 
Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
ou copier/coller dans votre navigateur Internet.
 
 http://housework.alwaysdata.net/index.php?p=member&action=activation&pseudo=' . urlencode($pseudo) . '&code=' . urlencode($code) . '&idMember=' . urlencode($idMember) . '

 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';
        return $mailDatas;
    }

    public function passwordNewAccount(string $pseudo, int $code, int $idMember) {
        $mailDatas = [];
        $mailDatas['sujet'] = "Votre compte sur Housework Manager";
        $mailDatas['entete'] = "From: housework@alwaysdata.net";


        $mailDatas['message'] = 'Bonjour' . urlencode($pseudo) . ',
 
Vous êtes invité à rejoindre votre famille sur Housework Manager. 
Pour cela, vous devez cliquer sur le lien ci-dessous afin de choisir un mot de passe et vous connectez à votre compte.
 
 http://housework.alwaysdata.net/index.php?p=member&action=passwordPage&login=' . urlencode($pseudo) . '&code=' . urlencode($code) . '&idMember=' . urlencode($idMember) . '

 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';
        return $mailDatas;
    }

    public function forgetPassword(string $pseudo, int $code, int $idMember) {
        $mailDatas = [];
        $mailDatas['sujet'] = "Réinitialiser votre mot de passe";
        $mailDatas['entete'] = "From: housework@alwaysdata.net";


        $mailDatas['message'] = 'Bonjour' . urlencode($pseudo) . ',
 
Pour réinitialiser votre mot de passe, cliquez sur le lien ci-dessous
ou copier/coller dans votre navigateur Internet.
 
 http://housework.alwaysdata.net/index.php?p=member&action=passwordPage&login=' . urlencode($pseudo) . '&code=' . urlencode($code) . '&idMember=' . urlencode($idMember) . '

 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';
        return $mailDatas;
    }

    public function sendMail($destinataire, $datasMail)
    {
        $result = mail($destinataire, $datasMail['sujet'], $datasMail['message'], $datasMail['entete']);
        if (!$result) {
            echo 'le mail n\'a pas été envoyé';
        } else {
            echo 'le mail a été envoyé';
        }

    }

}


