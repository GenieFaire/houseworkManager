<h1 class="text-success">Les tâches</h1>


<table id="table" class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Nom de la tâche</th>
        <th scope="col">Durée</th>
        <th scope="col">Age minimum</th>
        <th scope="col">Pièce</th>
        <th scope="col" data-field="category" data-filter-control="select">Catégorie</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach (\App\Entity\Task::getLast() as $task) {
        var_dump($task);?>

        <tr>
            <th scope="row"><?= $task->taskName; ?></th>
            <td><?= $task->duration; ?></td>
            <td><?= $task->minimumAge; ?></td>
            <td><?= $task->placeName; ?></td>
            <td><?= $task->categoryName; ?></td>
            <td>
                <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modalUpdate-<?= $task->idTask ?>">Modifier
                </button>
            </td>
        </tr>


        <!--Fentre modale de modification-->
        <div class="modal fade" id="modalUpdate-<?= $task->idTask ?>" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <!--                    croix de fermeture-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="post" id="tes-<?= $task->idTask ?>">
                            <p>
                                <label>Nom de la tâche : </label>
                                <input name="taskName" type="text" maxlength="100"
                                       placeholder="<?= $task->taskName; ?>">
                            </p>
                            <p>
                                <label>Durée estimée : </label>
                                <input name="duration" type="number" placeholder="<?= $task->duration; ?>">
                            </p>
                            <p>
                                <label>Age minimum : </label>
                                <input name="minimumAge" type="number" placeholder="<?= $task->minimumAge; ?>">
                            </p>
                            <p>
                                <label>Récurrence (en jours) : </label>
                                <input name="minimumAge" type="number" placeholder="<?= $task->periodicity; ?>">
                            </p>
                            <p>
                                <label>Catégorie : </label>
                                <select name="category">
                                    <option value="<?= $task->idCategory ?>"><?= $task->categoryName; ?></option>
                                    <option value="2">Prendre soin de soi</option>
                                </select>
                            </p>
                            <p>
                                <label>Cette tâche est-elle attribuée à la même personne ? </label>
                                <select name="toAssign">
                                    <option value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>
                            </p>
                            <p>
                                <label>Pièce : </label>
                                <select name="place">
                                    <option value="1">Cuisine</option>
                                </select>
                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

    </tbody>
</table>
