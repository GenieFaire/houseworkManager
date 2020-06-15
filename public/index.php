<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

require '../App/Autoload.php';
App\Autoload::register();

use App\Controller\Router;

$router = new Router();
$router->requestRoute();