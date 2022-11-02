<?php

// Отвечает за доступ к методам Action класса AccountController
return array(
    'all' => array(
        'login',
        'logout',
        'register',
    ),
    'authorize' => array(
        'profile',
    ),
    'admin' => array(),
);
