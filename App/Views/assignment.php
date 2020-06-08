<p></p>
<h1>Les tâches à assigner</h1>

<p></p>
<table id="table" class="table table-hover">
    <thead>
    <tr>
        <th>Nom de la tâche</th>
        <th>Age minimum</th>
        <th>Pièce</th>
        <th>Récurrence (en jours)</th>
        <th>Date de début</th>
        <th>Durée de l'assignment</th>
        <th></th>
        <th></th>
    </tr>
    </thead>

    <tbody id="tab">
    <tr>
        <?php foreach ($datas['tasks'] as $task) : ?>

            <td>
                <p><?= $task->getTaskName(); ?></p>
            </td>
            <td>
                <p><?= $task->getMinimumAge(); ?></p>
            </td>
            <td>
                    <?php foreach ($datas['places'] as $place) : ?>
                        <p> <?php if ($task->getIdPlace() == $place->getIdPlace()) echo  $place->getPlaceName(); ?></p>
                    <?php endforeach; ?>
            </td>
            <td>
                <p><?= $task->getPeriodicity(); ?></p>
            </td>
        <form action="../public/index.php?p=tasktodo" method="post">
            <?php foreach ($datas['tasksToDo'] as $taskToDo) {
                if ($task->getIdTask() === $taskToDo->getIdTask()) {?>
            <td>
                <input type="date" name="date" class="form-control border-0"
                       value="<?php echo $taskToDo->getDate(); ?>">
            </td>
                <?php } }?>
            <td>
                <div>
                    <input type="radio" id="seven" name="assignmentDuring" value="7">
                    <label for="seven">Pour une semaine</label>
                </div>
                <div>
                    <input type="radio" id="thirty" name="assignmentDuring" value="30">
                    <label for="thirty">Pour un mois</label>
                </div>
                <div>
                    <input type="radio" id="once" name="assignmentDuring" value="1">
                    <label for="once">Pour cette fois</label>
                </div>

            </td>
            <td>
                <div>
                    <input type="radio" id="no" name="assignmentDuring" value="0">
                    <label for="once">Ne pas assigner</label>
                </div>
            </td>
             <td>
                 <input type="hidden" name="idTask" class="form-control border-0 hide"
                    value="<?= $task->getIdTask(); ?>">

                 <button type="submit" class="btn btn-success" name="action" value="assignment">Assigner</button>
            </td>
        </form>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
