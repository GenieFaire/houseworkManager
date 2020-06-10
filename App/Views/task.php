<p></p>
<h1><?php echo $datas['task']->getTaskName(); ?></h1>

<p></p>

<form action="../index.php?p=task" method="post">
    <input type="hidden" name="idTask" class="form-control border-0"
           value="<?= $datas['task']->getIdTask(); ?>">
    <div class="row justify-content-center">
        <div class="form-group col-4">
            <div class="form-group">
                <label for="taskName">Nom de la tâche :</label>
                <input type="text" name="taskName" id="taskName" class="form-control border-0"
                       value="<?= $datas['task']->getTaskName(); ?>">
            </div>
            <div class="row justify-content-between">
                <div class="form-group col-6">
                    <label for="duration">Durée estimée :</label>
                    <input type="number" name="duration" id="duration" class="form-control border-0"
                           value="<?= $datas['task']->getDuration(); ?>">
                </div>
                <div class="form-group col-6">
                    <label for="age">Age minimum :</label>
                    <input type="number" name="minimumAge" id="age" class="form-control border-0"
                           value="<?= $datas['task']->getMinimumAge(); ?>">
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="form-group col-6">
                    <label for="place">Lieu :</label>
                    <select name="idPlace" id="place" class="form-control border-0">
                        <?php foreach ($datas['places'] as $place) : ?>
                            <option value="<?= $place->getIdPlace() ?>" <?php if ($datas['task']->getIdPlace() == $place->getIdPlace()) echo 'selected'; ?>><?= $place->getPlaceName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="periodicity">Récurrence (en jours) :</label>
                    <input type="number" name="periodicity" id="periodicity" class="form-control border-0"
                           value="<?= $datas['task']->getPeriodicity(); ?>">
                </div>
            </div>

            <div class="row justify-content-between">
            <div class="form-group col-6">
                <label for="category">Catégorie de la tâche :</label>
                <select name="category" id="category" class="form-control border-0">
                    <?php foreach ($datas['categories'] as $category) : ?>
                        <option value="<?= $category->getIdCategory() ?>" <?php if ($datas['task']->getIdCategory() == $category->getIdCategory()) echo 'selected'; ?>><?= $category->getCategoryName(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
                <div class="form-group col-6">
                    <label for="date">Date :</label>
                    <input type="date" name="date" id="date" class="form-control border-0"
                           value="<?= $datas['taskToDo']->getDate(); ?>">
                </div>
            </div>
        </div>
        <div class="form-group col-4">
            <div class="form-group">
                <label for="idMember">Personne qui doit accomplir la tâche :</label>
                <select id="idMember" name="idMember" class="form-control">
                    <?php foreach ($datas['taskToDo'] as $taskToDo) :
                        foreach ($datas['members'] as $member)  :
                            if ($datas['task']->getIdTask() === $taskToDo->getIdTask()) {
                                if ($taskToDo->getIdMember() === 0) {
                                    echo "<option value='0' selected>A Assigner</option>";
                                } elseif ($member->getIdMember() === $taskToDo->getIdMember()) {
                                    echo "<option value=" . $member->getIdMember() . "selected>" . $member->getPseudo() . "</option>";
                                }
                            }
                        endforeach;
                    endforeach; ?>
                    <?php foreach ($datas['members'] as $member) :
                        echo "<option value=" . $member->getIdMember() . ">" . $member->getPseudo() . "</option>";
                    endforeach; ?>
                    <option value='0'></option>

                </select>
                <p>Laissez le champ vide si vous souhaitez que la tâche soit attribuée automatiquement.</p>
            </div>
            <div class="form-group row">
                <p>Pour quelle durée souhaitez-vous assigner la tâche à une même personne :</p>
                <div class="col-5">
                    <input type="radio" id="seven" name="assignmentDuring" value="7">
                    <label for="seven">Pour une semaine</label>
                </div>
                <div class="col-5">
                    <input type="radio" id="thirty" name="assignmentDuring" value="30">
                    <label for="thirty">Pour un mois</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-5">
                    <input type="radio" id="once" name="assignmentDuring" value="1">
                    <label for="once">Pour cette fois</label>
                </div>
                <div class="col-5">
                    <input type="radio" id="no" name="assignmentDuring" value="0">
                    <label for="once">Ne pas assigner</label>
                </div>
            </div>
        </div>
    </div>
</form>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-lg pink-button" name="action" value="update">Enregistrer</button>
        <button class="btn btn-lg blue-button" data-toggle="modal"
                data-target=".modalDelete-<?= $datas['task']->getIdTask(); ?>">
            Supprimer
        </button>
    </div>



<!--Fentre modale de suppression-->
<div class="modal fade modalDelete-<?= $datas['task']->getIdTask(); ?>" role="dialog"
     aria-labelledby="exampleModalLabel-<?= $datas['task']->getIdTask(); ?>">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-<?= $datas['task']->getIdTask(); ?>"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Etes-vous sur de vouloir supprimer <strong><?= $datas['task']->getTaskName(); ?></strong>
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-lg pink-button" data-dismiss="modal">Non</button>
                <form action="index.php?p=task&action=delete" method="post">
                    <button type="submit" class="btn blue-button" name="idTask"
                            value="<?= $datas['task']->getIdTask(); ?>">Oui
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>





