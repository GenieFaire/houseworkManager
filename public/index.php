<?php

use App\Database;

require '../App/Autoload.php';
App\Autoload::register();

if (isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p = 'home';
}



ob_start();
if ($p === 'home') {
    require '../pages/home.php';
} elseif ($p === 'tasks') {
    require '../pages/tasks.php';
} elseif ($p === 'single') {
    require '../pages/single.php';
} elseif ($p === 'categories') {
    require '../pages/categories.php';
}
$content = ob_get_clean();
require '../pages/templates/default.php';