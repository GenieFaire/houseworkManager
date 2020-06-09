<p></p>
<h1>Les tâches</h1>
<p></p>
<button id="add" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalAdd">Ajouter une tâche
</button>
<p></p>
<table id="table" class="table table-hover">
    <thead>
    <tr>
        <th style="width:5%;">Id</th>
        <th style="width:20%;">Nom de la tâche</th>
        <th style="width:5%;">Durée</th>
        <th style="width:5%;">Age minimum</th>
        <th style="width:15%;">Pièce</th>
        <th data-field="category" data-filter-control="select" style="width:25%;">Catégorie</th>
        <th style="width:10%;">Récurrence (en jours)</th>
        <th style="width:10%;">Membre</th>
        <th style="width:10%"></th>
        <th style="width:10%"></th>
    </tr>
    </thead>

    <tbody id="tab">
    <tr>
        <?php foreach ($datas['tasks']

        as $task) : ?>
        <form action="../index.php?p=task" method="post">
            <th><input type="text" name="idTask" class="form-control border-0"
                       value="<?= $task->getIdTask(); ?>" READONLY></th>
            <td><input type="text" name="taskName" class="form-control border-0"
                       value="<?= $task->getTaskName(); ?>"></td>
            <td><input type="number" name="duration" class="form-control border-0"
                       value="<?= $task->getDuration(); ?>"></td>
            <td><input type="number" name="minimumAge" class="form-control border-0"
                       value="<?= $task->getMinimumAge(); ?>"></td>
            <td>
                <select name="idPlace" class="form-control border-0">
                    <?php foreach ($datas['places'] as $place) : ?>
                        <option value="<?= $place->getIdPlace() ?>" <?php if ($task->getIdPlace() == $place->getIdPlace()) echo 'selected'; ?>><?= $place->getPlaceName(); ?></option>
                    <?php endforeach; ?>
                </select></td>
            <td>
                <select name="category" class="form-control border-0">
                    <?php foreach ($datas['categories'] as $category) : ?>
                        <option value="<?= $category->getIdCategory() ?>" <?php if ($task->getIdCategory() == $category->getIdCategory()) echo 'selected'; ?>><?= $category->getCategoryName(); ?></option>
                    <?php endforeach; ?>
                </select></td>
            <td><input type="number" name="periodicity" class="form-control border-0"
                       value="<?= $task->getPeriodicity(); ?>"></td>
            <td>
                <select id="idMember" name="idMember" class="form-control">
                    <?php foreach ($datas['members'] as $member)    {
                        foreach ($datas['tasksToDo'] as $taskToDo) ?>
                        <option value="<?= $member->getIdMember() ?>" <?php if ($member->getIdMember() === $taskToDo->getIdMember())  echo 'selected'; ?>><?= $member->getPseudo(); ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <button type="submit" class="btn btn-success" name="action" value="update">Modifier</button>
            </td>
        </form>
        <td>
            <button class="btn btn-danger" data-toggle="modal" data-target=".modalDelete-<?= $task->getIdTask(); ?>">
                Supprimer
            </button>
        </td>
    </tr>

    <!--Fentre modale de suppression-->
    <div class="modal fade modalDelete-<?= $task->getIdTask(); ?>" role="dialog"
         aria-labelledby="exampleModalLabel-<?= $task->getIdTask(); ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-<?= $task->getIdTask(); ?>"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Etes-vous sur de vouloir supprimer <strong><?= $task->getTaskName(); ?></strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Non</button>
                    <form action="../index.php?p=task&action=delete" method="post">
                        <button type="submit" class="btn btn-primary" name="idTask"
                                value="<?= $task->getIdTask(); ?>">Oui
                        </button>
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
                <h5 class="modal-title" id="exampleModalLabel">Ajouter une nouvelle tâche</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="insert" action="../index.php?p=task&action=add" method="post">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="taskName" class="col-form-label">Nom de la tâche : </label>
                            <input id="taskName" name="taskName" class="form-control" type="text" maxlength="100">
                            <label for="duration" class="col-form-label">Durée estimée : </label>
                            <input id="duration" name="duration" class="form-control" type="number">
                            <label for="minimumAge" class="col-form-label">Age minimum : </label>
                            <input id="minimumAge" name="minimumAge" class="form-control" type="number">
                            <label for="periodicity" class="col-form-label">Récurrence (en jours) : </label>
                            <input id="periodicity" name="periodicity" class="form-control" type="number">
                        </div>
                        <div class="form-group col-6">
                            <label for="idMember" class="col-form-label">A qui :</label>
                            <select id="idMember" name="idMember" class="form-control">
                                <?php foreach ($datas['members'] as $member) : ?>
                                    <option value="<?= $member->getIdMember() ?>"><?= $member->getPseudo(); ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="idCategory" class="col-form-label">Catégorie : </label>
                            <select id="idCategory" name="idCategory" class="form-control">
                                <?php foreach ($datas['categories'] as $category) : ?>
                                    <option value="<?= $category->getIdCategory() ?>"><?= $category->getCategoryName(); ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="idPlace" class="col-form-label">Pièce : </label>
                            <select id="idPlace" name="idPlace" class="form-control">
                                <?php foreach ($datas['places'] as $place) : ?>
                                    <option value="<?= $place->getIdPlace() ?>"><?= $place->getPlaceName(); ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="add">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!--<script>-->
<!--    // TODO faire une liste de members aussi ici-->
<!--    function printMembers() {-->
<!--        let field = document.getElementById('choose');-->
<!--        let toAssign = document.getElementById('toAssign2').value;-->
<!--        console.log(toAssign);-->
<!--        console.log(field);-->
<!--        if (toAssign == 1) {-->
<!--            field.style.display = "block";-->
<!--            // field.className = 'd-flex';-->
<!--            // label.className = 'd-flex';-->
<!--        } else if (toAssign == 0) {-->
<!--            field.style.display = "none";-->
<!--            // field.className = 'd-none';-->
<!--            // label.className = 'd-none';-->
<!--        }-->
<!--    }-->
<!--</script>-->


