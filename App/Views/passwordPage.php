<div class="password-form row">
    <form action="../index.php?p=member" method="post">
        <input name="idMember" type="hidden" value="<?=$datas['idMember'] ?>"/>
        <input name="code" type="hidden" value="<?=$datas['code'] ?>"/>

        <div class="form-group">
            <label for="password">Mot de passe : </label>
            <input id="password" name="password" class="form-control" type="password"/>
        </div>
        <div class="form-group">
            <label for="passwordverif" class="col-form-label" >Saisissez à nouveau le mot de passe : </label>
            <input id="passwordverif" name="passwordverif" class="form-control" type="password" onkeyup="passwordVerification()"/>
            <div id="err"></div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn blue-button" name="action" value="password">
        </div>
    </form>
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
