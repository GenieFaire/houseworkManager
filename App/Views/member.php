<p></p>
<div class="container text-center col-6 mt-5 border border-primary info-container rounded">

<h3>Vos informations</h3>
<div class="form-group">

<form action="../index.php?p=member" method="post">
    <div class="form-group">
        <input type="hidden" name="idMember"
               value="<?= $datas->getIdMember(); ?>">

    <label class="col-form-label-lg">Pseudo</label>
    <input type="text" name="pseudo" class="form-control form-control-lg"
           value="<?= $datas->getPseudo(); ?>">
    </div>
    <div class="form-group">
        <label for="password" class="col-form-label">Mot de passe : </label>
        <input id="password" name="password" class="form-control" type="password"/>
        <label for="passwordverif" class="col-form-label" >Saisissez à nouveau le mot de passe : </label>
        <input id="passwordverif" name="passwordverif" class="form-control" type="password" onkeyup="passwordVerification()"/>
        <div id="err"></div>
    </div>
        <div class="form-group">
    <label class="col-form-label-lg">date de naissance</label>
    <input type="date" name="birthday" class="form-control form-control-lg"
           value="<?= $datas->getBirthday() ?>">
        </div>
            <div class="form-group">
    <label class="col-form-label-lg">mail</label>
    <input type="email" name="mail" class="form-control form-control-lg"
           value="<?= $datas->getMail(); ?>">
            </div>
                <div class="form-group">
    <button type="submit" class="btn blue-button btn-lg" name="action" value="update">Modifier</button>
                </div>
</form>
</div>
</div>

<script>
    function passwordVerification()
    {
        if(document.getElementById("password").value != document.getElementById("passwordverif").value) {
            document.getElementById("err").innerHTML = "<p style='color:#ff0000'>Les deux mots de passe ne sont pas identiques</p>";
        }
        else {
            document.getElementById("err").innerHTML = "<p style='color:green'>mot de passe valide</p>";
        }
    }
</script>