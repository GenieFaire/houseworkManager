$( document ).ready(function() {
    let error = <?php print $error; ?>;
    let inputPseudo = document.getElementById('pseudo');

    if (error === 1) {
        let monDiv = document.getElementById("connect");
        monDiv.style.display = "none";
        let monDiv2 = document.getElementById("inscription");
        monDiv2.style.display = "none";
        let monSpan = document.createElement("span");
        monSpan.setAttribute("id", "s");
        monSpan.setAttribute("class", "row col-12 align-self-center");
        monSpan.innerHTML = "Echec de la connexion. Nom de compte ou mot de passe incorrect !";
        monDiv.parentElement.appendChild(monSpan);
        let monBr = document.createElement("br");
        monDiv.parentElement.appendChild(monBr);
        let monButton = document.createElement("button");
        monButton.setAttribute("id", "button");
        monButton.innerHTML = "Recommencer";
        monButton.setAttribute("type", "button");
        monButton.setAttribute("class", "btn btn-success");
        monButton.onclick = function () {
            monDiv.style.display = "block";
            monDiv2.style.display = "block";
            monButton.remove();
            monSpan.remove();
        };
        monDiv.parentElement.appendChild(monButton);
    }
    });
