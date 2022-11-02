<?php

namespace app\controller;

use app\core\Controller;

class MainController extends Controller 
{
    public function indexAction()
    {
        // Отображение страницы
        $this->view->render('Главная');
    }
}
