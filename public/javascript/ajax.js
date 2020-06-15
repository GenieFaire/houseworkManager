function uniquePseudo() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = xhr.responseText;
            if (response !== '0') {
                document.getElementById('pseudoCheck').innerHTML = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
            } else {
                document.getElementById('pseudoCheck').innerHTML = " ";
            }
        }
    }
    xhr.open("POST", "index.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    let pseudo = document.getElementById('pseudo').value;
    xhr.send("p=member&action=checkPseudo&pseudo=" + pseudo);
}

function uniquePseudo2(e) {

    let idPseudo = e.getAttribute('id');

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = xhr.responseText;
            if (idPseudo === "newMember") {
                if (response !== '0') {
                    document.getElementById('pseudoCheck2').innerHTML = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
                } else {
                    document.getElementById('pseudoCheck2').innerHTML = " ";
                }
            } else {
                if (response !== '0') {
                    document.getElementById('pseudoCheck').innerHTML = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
                } else {
                    document.getElementById('pseudoCheck').innerHTML = " ";
                }
            }
        }
    }

    xhr.open("POST", "index.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    let pseudo = document.getElementById(idPseudo).value;
    xhr.send("p=member&action=checkPseudo&pseudo=" + pseudo);
}
