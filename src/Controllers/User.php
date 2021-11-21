<?php

namespace Controllers;

class User extends Controller
{
    public function register($requestData = []): string
    {
        return  $this->view->render('Auth', [
            'navbarRightText' => 'Войти',
            'navbarRightUrl' => 'login',
            'formButtonText' => 'Зарегистрироваться',
            'formUrl' => 'register',
            'addPost' => 'invisible',
            'error' => empty($requestData['error']) ? '' : $requestData['error']
        ]);
    }

    public function login($requestData = []): string
    {
        return  $this->view->render('Auth', [
            'content' => 'Tanya',
            'navbarRightText' => 'Зарегистрироваться',
            'navbarRightUrl' => 'register',
            'formButtonText' => 'Войти',
            'formUrl' => 'login',
            'addPost' => 'invisible',
            'error' => empty($requestData['error']) ? '' : 'Не верный логин или пароль'
        ]);
    }
}
