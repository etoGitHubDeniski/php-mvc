<?php

namespace app\core;

use app\core\View;

abstract class Controller
{
    public $route;
    public $view;
    public $model;
    public $acl;

    public function __construct($route)
    {
        $this->route = $route;                                          // Для доступа вне функции
        if (!$this->checkAcl()) {                                       // Проверяем уровень доступа
            View::errorCode(403, 'Доступ запрещен');
        }
        $this->view = new View($route);                                 // Создаем экземпляр класса View, передаем параметры маршрута
        $this->model = $this->loadModel($route['controller']);          // Создаем экземпляр класса Model
    }

    // Подключает модель
    public function loadModel($name)
    {
        $path = 'app\model\\' . ucfirst($name) . 'Model';
        if (class_exists($path)) {
            return new $path;
        }
    }

    // Проверяет доступ
    public function checkAcl()
    {
        // Подключаем файл с доступами
        $this->acl = require 'app/acl/' . $this->route['controller'] . '.php';
        
        // Ищем соответствия
        if ($this->isAcl('all') || (isset($_SESSION['admin']))) {
            return true;
        } elseif ($this->isAcl('authorize') && isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    // Находит в массиве соответствие
    public function isAcl($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}
