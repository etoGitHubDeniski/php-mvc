<?php

namespace app\controller;

use app\core\Controller;

class AccountController extends Controller
{
    // Страница входа
    public function loginAction()
    {
        // Редирект, если уже авторизован
        if (isset($_SESSION['user'])) {
            $this->view->redirect($_SESSION['user']);
        }
        // Отображение страницы
        $this->view->render('Добро пожаловать');
    }

    // Страница входа
    public function logoutAction()
    {
        // Редирект, если уже авторизован, если не авторизован, то тоже редирект
        // Тут даже вид не нужен, это точно так должно работать?
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        $this->view->redirect('login');
    }

    // Страница входа
    public function registerAction()
    {
        // Отображение страницы
        $this->view->render('Зарегистрироваться');
    }

    // Страница входа
    public function profileAction()
    {
        // Редирект на страницу юзера
        if (isset($_SESSION['user']) && $_SERVER['REQUEST_URI'] == '/profile') {
            $this->view->redirect($_SESSION['user']);
        }
        // Отображение страницы юзера (да, редирект идет еще раз сюда если срабатывает)
        $this->view->render('Профиль');
    }
}
