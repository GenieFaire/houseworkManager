<p></p>
<h1>Les tâches</h1>
<?php if ($datas['tasksToDo'] == null) { ?>
    <button id="add" class="btn pink-button btn-lg" data-toggle="modal" data-target="#modalAdd">Ajouter une tâche
    </button>
    <?php } else { ?>
<button id="add" class="btn pink-button btn-lg" data-toggle="modal" data-target="#modalAdd">Ajouter une tâche
</button>
<p></p>
<table id="table" class="table table-hover" data-toggle="table" data-search="true">
    <thead>
    <tr>
        <th style="width:20%;">Nom de la tâche</th>
        <th style="width:5%;">Durée</th>
        <th data-sortable="true" data-field="age" style="width:5%;">Age minimum</th>
        <th data-sortable="true" data-field="place" style="width:15%;">Pièce</th>
        <th data-sortable="true" data-field="category" style="width:20%;">Catégorie</th>
        <th style="width:10%;">Récurrence (en jours)</th>
        <th data-sortable="true" data-field="member" style="width:10%;">Membre</th>
        <th style="width:10%"></th>
        <th style="width:10%"></th>
    </tr>
    </thead>

    <tbody id="tab">
    <tr>
        <?php foreach ($datas['tasks'] as $task) : ?>
        <input type="text" name="idTask" class="form-control border-0 hide"
               value="<?= $task->getIdTask(); ?>" READONLY>
        <td><?= $task->getTaskName(); ?></td>
        <td><?= $task->getDuration(); ?></td>
        <td><?= $task->getMinimumAge(); ?></td>
        <td>
            <?php foreach ($datas['places'] as $place) : ?>
                <?php if ($task->getIdPlace() == $place->getIdPlace()) echo $place->getPlaceName(); ?>
            <?php endforeach; ?>
        </td>
        <td>
            <?php foreach ($datas['categories'] as $category) : ?>
                <?php if ($task->getIdCategory() == $category->getIdCategory()) echo $category->getCategoryName(); ?>
            <?php endforeach; ?>
        </td>
        <td><?= $task->getPeriodicity(); ?></td>
        <td>
            <?php foreach ($datas['tasksToDo'] as $taskToDo) :
                foreach ($datas['members'] as $member)  :
                    if ($task->getIdTask() == $taskToDo->getIdTask() && $member->getIdMember() == $taskToDo->getIdMember()) {
                            echo $member->getPseudo();
                    }
                endforeach;
            endforeach; ?>
        </td>
        <td>
            <a href="index.php?p=task&idTask=<?= $task->getIdTask() ?>" class="btn pink-button">Modifier</a>
        </td>
        <td>
            <button class="btn blue-button" data-toggle="modal" data-target=".modalDelete-<?= $task->getIdTask(); ?>">
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
                    <button class="btn pink-button" data-dismiss="modal">Non</button>
                    <form action="../index.php?p=task&action=delete" method="post">
                        <button type="submit" class="btn blue-button" name="idTask"
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
<?php } ?>


<!--modale d'insertion-->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog"
     aria-labelledby="Modal d'insertion"
     aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Ajouter une nouvelle tâche</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="insert" action="../index.php?p=task" method="post">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="taskName" class="col-form-label">Nom de la tâche : </label>
                            <input id="taskName" name="taskName" class="form-control" type="text" maxlength="100">
                            <div class="row justify-content-between">
                                <div class="form-group col-6">
                                <label for="duration" class="col-form-label">Durée estimée : </label>
                                <input id="duration" name="duration" class="form-control" type="number">
                                </div>
                                <div class="form-group col-6">
                                <label for="minimumAge" class="col-form-label">Age minimum : </label>
                                <input id="minimumAge" name="minimumAge" class="form-control" type="number">
                                </div>
                            </div>
                            <label for="periodicity" class="col-form-label">Récurrence (en jours) : </label>
                            <input id="periodicity" name="periodicity" class="form-control" type="number">
                            <small class="form-text text-muted">mettre 0 si elle ne se répète pas</small>
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

                        <div class="form-group col-6">
                            <div class="form-group">
                                <label for="date" class="col-form-label">Date de début : </label>
                                <input id="date" name="date" class="form-control" type="date">
                                <small class="form-text text-muted">laissez vide pour un début dès aujourd'hui</small>
                                <label for="idMember" class="col-form-label">A qui :</label>
                                <select id="idMember" name="idMember" class="form-control">
                                    <option value="0">à assigner aléatoirement</option>
                                    <?php foreach ($datas['members'] as $member) : ?>
                                        <option value="<?= $member->getIdMember() ?>"><?= $member->getPseudo(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="form-group row">
                                <div class="col-12">
                                    <p>Pour quelle durée souhaitez-vous assigner la tâche à une même personne :</p>
                                </div>

                                <div class="col-6">
                                    <input type="radio" id="seven" name="assignmentDuring" value="7">
                                    <label for="seven">Pour une semaine</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" id="thirty" name="assignmentDuring" value="30">
                                    <label for="thirty">Pour un mois</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <input type="radio" id="once" name="assignmentDuring" value="1">
                                    <label for="once">Pour cette fois</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" id="no" name="assignmentDuring" value="0">
                                    <label for="once">Ne pas assigner</label>
                                </div>
                                <div class="col-12">
                                <small class="form-text text-muted">Vous pourrez changer l'assignation à tout moment</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn blue-button" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn pink-button" name="action" value="addTask">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

