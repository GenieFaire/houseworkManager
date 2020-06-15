<div class="container-fluid justify-items-center">
    <div class="row justify-content-center align-items-center  title">
        <h1>Bonjour <?= $_SESSION['pseudo'] ?></h1>
    </div>
    <div class="row justify-content-center align-items-center">
    </div>
    <div class="row dashboardContainer">
        <!--        les tâches à faire-->
        <div class="column col-6">
            <?php setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
            if ($datas === null) { ?>
                <h3>Vous n'avez aucune tâche à effectuer</h3>
            <?php } else {

            foreach ($datas['uniqueDates'] as $date) { ?>

                <h4 class="date"><?= strftime('%A %d %B %Y', strtotime($date)); ?></h4>
                <?php foreach ($datas['tasksToDo'] as $taskToDo) :
                    foreach ($datas['tasks'] as $task) :
                    if (date('d-m-Y', strtotime($date)) == date('d-m-Y', strtotime($taskToDo->getDate())) && $task->getIdTask() == $taskToDo->getIdTask()) {
                        ?>

                                <div class="row task">
                                    <div class="task-header"><h3><?= $task->getTaskName() ?></h3></div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php foreach ($datas['places'] as $place) {
                                                if ($task->getIdPlace() == $place->getIdPlace()) {
                                                    echo $place->getPlaceName();
                                                    echo $taskToDo->getDate();
                                                }
                                            } ?></h5>
                                        <h5 class="card-text"><?php echo "Durée (en minutes) : " . $task->getDuration() ?></h5>
                                    </div>
                                    <div class="task-footer">
                                        <form action="../index.php?p=task&action=done" method="post">
                                            <button type="submit" class="btn pink-button" name="idTask"
                                                    value="<?= $task->getIdTask() ?> ">J'ai
                                                fini
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            <?php }

                        endforeach;

                endforeach;
            } }?>
        </div>
        <!--        Le menu-->
        <div class="column col-4">
            <div class="card">
                <div class="card-desk text-center">
                    <div class="card-body">
                        <h3 class="card-title">Mon compte</h3>
                        <p class="card-text">Vos informations personnelles</p>
                        <a href="../index.php?p=member&action=account" class="btn pink-button">c'est parti</a>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['grade'] === true) { ?>
            <div class="card">
                <div class="card-desk text-center">
                    <div class="card-body">
                        <h3 class="card-title">Gérer les tâches de la famille</h3>
                        <p class="card-text">C'est ici que l'on crée, ajoute ou supprime des tâches</p>
                        <a href="../index.php?p=task" class="btn pink-button">C'est parti</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-desk text-center">
                    <div class="card-body">
                        <h3 class="card-title">Gérer les membres de la famille</h3>
                        <p class="card-text">C'est ici que l'on crée, ajoute ou supprime des membres</p>
                        <a href="../index.php?p=family" class="btn pink-button">C'est parti</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>
