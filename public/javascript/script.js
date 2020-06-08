$( document ).ready(function() {
    console.log( "ready!" );
});

function passwordVerification()
{
    if(document.getElementById("password").value != document.getElementById("passwordverif").value) {
        document.getElementById("err").innerHTML = "<p style='color:#ff0000'>Les deux mots de passe ne sont identiques</p>";
    }
    else {
        document.getElementById("err").innerHTML = "<p style='color:green'>mot de passe valide</p>";
    }
}
