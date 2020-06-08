<?php
if (!isset($_GET['id'])) {
    echo 'id non défini';
    exit;
}
$id = (int)$_GET['id'];


$task = $db->prepare("SELECT * FROM task WHERE idTask=$id");
?>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Nom de la tâche</th>
        <th scope="col">durée</th>
        <th scope="col">Age minimum</th>
        <th scope="col">pièce</th>
    </tr>
    </thead>
    <tbody>
    <h1><?= $task->taskName; ?></h1>

    <tr>
        <th scope="row"><?= $task->taskName; ?></th>
        <td><?= $task->duration; ?></td>
        <td><?= $task->minimumAge; ?></td>
        <td><?= $task->place; ?></td>
<!--        <td>-->
<!--            <button class="btn btn-success"><a href="--><?//= $task->getUrl() ?><!--">Modifier</a></button>-->
<!--        </td>-->
<!--        <td>-->
<!--            <button class="btn btn-danger"><a href="--><?//= $task->getUrl() ?><!--">Supprimer</a></button>-->
<!--        </td>-->
    </tr>
    </tbody>
</table>