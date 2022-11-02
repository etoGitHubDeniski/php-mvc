<?php

// Включает ошибки
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Показывает содержимое переменных, останавливает выполнение кода
function debug($arg)
{
    echo '<pre>';
    var_dump($arg);
    echo '</pre>';
    exit;
}
