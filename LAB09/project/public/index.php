<?php
$c = $_GET['c'] ?? 'student';
$a = $_GET['a'] ?? 'index';

$controllerName = ucfirst($c) . 'Controller';
require "../app/controllers/$controllerName.php";

$controller = new $controllerName();
$controller->$a();
