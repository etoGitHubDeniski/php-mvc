<?php

// Список маршрутов и их параметров
// Маршрут => array( название класса контроллера, название метода )
return array (
    // MainController
    '' => array(
        'controller' => 'main',
        'action' => 'index',
    ),

    // AccountController
    'login' => array (
        'controller' => 'account',
        'action' => 'login',
    ),
    'logout' => array (
        'controller' => 'account',
        'action' => 'logout',
    ),
    'register' => array (
        'controller' => 'account',
        'action' => 'register',
    ),
    'profile' => array (
        'controller' => 'account',
        'action' => 'profile',
    ),
    '{profile:\w+}' => array (
        'controller' => 'account',
        'action' => 'profile',
    ),
);
