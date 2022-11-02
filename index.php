<?php

session_start();

// Для отладки
require 'app/lib/Dev.php';

use app\core\Router;

// Автозагрузка класса
spl_autoload_register(function($class)
{
    $path = str_replace('\\', '/', $class . '.php');
    if (file_exists($path)) require $path;
});

$router = new Router;
$router->run();
