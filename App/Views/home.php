<div class="container-fluid  justify-content-center ">
    <div class="row justify-content-center align-items-center title">
        <h1>Bienvenue sur le housework-manager</h1>
    </div>
    <div class="row justify-content-around">

        <div class="align-items-center justify-content-center inscription col-4" id="inscription">
            <h2>S'inscrire</h2></br>
            <button class="btn btn-lg" data-toggle="modal" data-target="#modalNewFamily">Inscription</button>
        </div>
        <div class="row justify-content-center col-4" id="connect">
            <div class="row justify-content-center">
                <div class="col">
                    <h2>Se connecter</h2>
                    <div id="erreur"></div>
                    <form method='post' enctype="multipart/form-data" action='../index.php?p=member'
                          class="">
                        <div class="form-group">
                            <label for="pseudo">Pseudo</label>
                            <input name="pseudo" type="text" maxlength="50"/>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input id="password" name="password" type="password" maxlength="50"/>
                        </div>
                        <button type="submit" class="btn btn-lg" name="action" value="connexion">Connexion</button>
                    </form>
                    <a href="../index.php?p=member&action=recoveryPassword" id="recoveryPassword"
                       data-toggle="modal"
                       data-target="#recoveryPasswordModal">Mot de passe oublié ?</a>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNewFamily" tabindex="-1" role="dialog"
     aria-labelledby="Modal de création de compte"
     aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Créer un compte</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../index.php?p=family" method="post">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="pseudo" class="col-form-label">Votre pseudo : </label>
                            <input id="pseudo" name="pseudo" class="form-control" type="text" maxlength="50"
                                   onblur="uniquePseudo()">
                            <p id="pseudoCheck"></p>
                            <label for="password" class="col-form-label">Votre mot de passe : </label>
                            <input name="password" class="form-control" type="password">
                            <label for="birthday" class="col-form-label">Votre date de naissance : </label>
                            <input name="birthday" class="form-control" type="date">
                            <label for="mail" class="col-form-label">Votre adresse mail : </label>
                            <input name="mail" class="form-control" type="email">
                            <label for="familyName" class="col-form-label">Le nom de votre famille : </label>
                            <input name="familyName" class="form-control" type="text" maxlength="45">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn close" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn" name="action" value="addFamily">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="recoveryPasswordModal" tabindex="-1" role="dialog"
     aria-labelledby="Modal de création de compte"
     aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Réinitialiser votre mot de passe</h2>
            </div>
            <div class="modal-body">
                <form action="../index.php?p=member" method="post">
                    <div class="form-group col-12">
                        <label for="pseudo" class="col-form-label">Votre pseudo : </label>
                        <input name="pseudo" class="form-control" type="text">
                        <label for="mail" class="col-form-label">Votre adresse mail : </label>
                        <input name="mail" class="form-control" type="email">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn close" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn" name="action" value="recoveryPassword">Réinitialiser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_GET['param'])) {
    $param = $_GET['param'];
} else {
    $param = -1;
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        let param = <?php print $param; ?>;

        if (param === 1) {
            let div = document.getElementById('erreur');
            div.innerHTML = "Echec de la connexion. Nom de compte ou mot de passe incorrect !";
        } else if (param === 2) {
            alert("Un mail vient de vous être envoyé. Veuillez suivre les instructions qu'il contient");
        } else if (param === 3) {
            alert("Mot de passe ou email incorrect.");
        } else if (param === 4) {
            alert("Votre compte n'est pas activé. ");
        } else if (param === 6) {
            alert("Une erreur est survenue, veuillez réessayer.");
        }
    });</script>

<script type='text/javascript'>
    function uniquePseudo() {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = xhr.responseText;
                console.log(response);
                if (response !== '0') {
                    document.getElementById('pseudoCheck').innerHTML = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
                } else {
                    document.getElementById('pseudoCheck').innerHTML = "excellent choix !";
                }
            }
        }
        xhr.open("POST", "index.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        let pseudo = document.getElementById('pseudo').value;
        xhr.send("p=member&action=checkPseudo&pseudo=" + pseudo);
    }
</script>