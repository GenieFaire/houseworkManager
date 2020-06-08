<form action="../public/index.php?p=member" method="post">
    <div class="form-group col-6">
        <input name="idMember" class="hide" value="<?=$datas['idMember'] ?>"/>
        <input name="code" class="hide" value="<?=$datas['code'] ?>/>
        <label for="password" class="col-form-label">Mot de passe : </label>
        <input id="password" name="password" class="form-control" type="password"/>
        <label for="passwordverif" class="col-form-label" >Saisissez à nouveau le mot de passe : </label>
        <input id="passwordverif" name="passwordverif" class="form-control" type="password" onkeyup="passwordVerification()"/>
        <div id="err"></div>
        <input type="submit" class="btn btn-primary" name="action" value="password">
    </div>
</form>


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
