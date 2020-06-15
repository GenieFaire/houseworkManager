<h1>Voici les membres de la famille</h1>
<div class="col-11">
<p></p>
<button id="add" class="btn pink-button btn-lg" data-toggle="modal" data-target="#modalAdd">Ajouter un membre
</button>



<p></p>
<table id="table" class="table table-hover">
    <thead>
    <tr>
        <th class="hide">Id</th>
        <th>Pseudo</th>
        <th>date de naissance</th>
        <th>droits</th>
        <th>mail</th>
        <th>Options</th>
    </tr>
    </thead>
    <tbody id="tab">
    <tr>
        <?php foreach ($datas as $member): ?>
        <form action="../index.php?p=member&idFamily=<?= $member->getIdFamily(); ?>" method="post">
            <th class="hide"><input type="text" name="idMember" class="form-control border-0"
                       value="<?= $member->getIdMember(); ?>" READONLY></th>
            <td><input type="text" name="pseudo" class="form-control border-0" id="pseudoValue-<?= $member->getIdMember(); ?>"
                       value="<?= $member->getPseudo(); ?>"  onblur="uniquePseudo2(this)"/>
                <p id="pseudoCheck"></p>
            </td>

            <td><input type="date"  name="birthday" class="form-control border-0"
                       value="<?= $member->getBirthday() ?>"></td>
            <td>
                <select name="grade" class="form-control border-0">
                    <option  value="0" <?php if($member->getGrade() == 0) echo 'selected'; ?>>Droits restreints</option>
                    <option  value="1" <?php if($member->getGrade() == 1) echo 'selected'; ?>>Tous les droits</option>
                </select>
            </td>
            <td><input type="email" name="mail" class="form-control border-0"
                       value="<?= $member->getMail(); ?>"></td>
            <td>
                <button type="submit" class="btn pink-button" name="action" value="update">Modifier</button>
                <button class="btn blue-button" data-toggle="modal" data-target=".modalDelete-<?=$member->getIdMember(); ?>">Supprimer</button>
            </td>
        </form>
    </tr>

</div>

    <!--modale de suppression de membres-->
    <div class="modal fade modalDelete-<?=$member->getIdMember(); ?>"  role="dialog"
         aria-labelledby="exampleModalLabel-<?=$member->getIdMember(); ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-<?=$member->getIdMember(); ?>"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Etes-vous sur de vouloir supprimer <strong><?= $member->getPseudo(); ?></strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn pink-button" data-dismiss="modal">Non</button>
                    <form action="../index.php?p=member&action=delete" method="post">
                        <button type="submit" class="btn blue-button" name="idMember"
                                value="<?= $member->getIdMember(); ?>">Oui</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
    </tbody>
</table>

<!--modale d'insertion-->

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog"
     aria-labelledby="Modal d'insertion"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un membre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../index.php?p=member&action=add" method="post">
                    <div class="row">
                        <input type="text" name="idFamily" value="<?= $_SESSION['idFamily']; ?>" HIDDEN/>
                        <div class="form-group col-6">
                            <label for="pseudo" class="col-form-label">Pseudo du membre : </label>
                            <input name="pseudo" class="form-control" type="text" id="newMember" maxlength="50" onblur="uniquePseudo2(this)"/>
                            <p id="pseudoCheck2"></p>
                            <label for="birthday" class="col-form-label">Date de naissance : </label>
                            <input name="birthday" class="form-control" type="date"/>
                        </div>
                        <div class="form-group col-6">
                            <label for="mail" class="col-form-label">Adresse email : </label>
                            <input name="mail" class="form-control" type="email"/>
                            <p></p>
                            <label for="grade" class="col-form-label">Droits du membre : </label>
                            <select name="grade" class="form-control">
                                <option value="0">Droits restreints</option>
                                <option value="1">Tous les droits</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn pink-button" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn blue-button" name="action" value="add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



