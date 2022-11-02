<?php

namespace app\core;

class View
{
    public $route;
    public $path;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    // Подключает вид
    public function render($title = '', $vars = array())
    {
        extract($vars);
        $path = 'app/view/' . $this->path . '.php';
        if (file_exists($path)) {
            $pathLayout = 'app/view/layout/' . $this->layout . '.php';
            ob_start();                                                         // стартует буфер
            require $path;                                                      // загружает вид в буфер
            $content = ob_get_clean();                                          // присаивает вид переменной
            require file_exists($pathLayout) ? $pathLayout : $path;             // если шаблон ни кто не забыл, то загрузится с шаблоном, иначе без.
        } else {
            $this->errorCode(404, 'Не найдено представление: ' . $this->path);
        }
    }

    // Перенаправляет запрос
    public function redirect($url)
    {
        header('Location: /' . $url);
        exit;
    }

    // Сообщает браузеро об ошибке
    // Загружает страницу с ошибкой
    public static function errorCode($code, $comment = '')
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $code);
        $path = 'app/view/error/' . $code . '.php';
        if (file_exists($path)) {
            $pathLayout = 'app/view/layout/error.php';
            ob_start();
            require $path;
            $content = ob_get_clean();
            require file_exists($pathLayout) ? $pathLayout : $path;
        } else {
            echo 'Ошибка ' . $code . '.<br>Комментарий: ' . $comment . '.<br>Не найдено представление ошибки.';
        }
        exit;
    }
}
