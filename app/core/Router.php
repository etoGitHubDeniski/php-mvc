<?php

namespace app\core;

use app\core\View;

class Router
{
    protected $routes = array();
    protected $params = array();

    // Подключает файл с маршрутами, загружает обработанные в регулярные
    // выражения маршруты в массив
    public function __construct()
    {
        $routes = require 'app/config/routes.php';
        foreach ($routes as $route => $params) {
            $this->add($route, $params);
        }
    }

    // Обрабатывает маршруты в регулярные выражения
    public function add($route, $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    // Проверяет URL со списком маршрутов, если найдены совпадения, добавляет
    // их к параметрам контроллера и метода. Если параметр число, приводит к типу int
    // Возвращает true если совпадение найдено
    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    // Запускает проверку запроса URL
    // Подключет Класс, создает экземпляр, вызывает метод, передает праметры маршрута в класс.
    // Говорит чего не хватает, если что то забыл
    public function run()
    {
        if ($this->match()) {
            $controllerName = ucfirst($this->params['controller']) . 'Controller';
            $path = 'app\controller\\' . $controllerName;
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404, 'Не найден метод :' . $action);
                }
            } else {
                View::errorCode(404, 'Не найден контроллер :' . $controllerName);
            }
        } else {
            View::errorCode(404, 'Не найден маршрут :' . trim($_SERVER['REQUEST_URI'], '/'));
        }
    }
}
