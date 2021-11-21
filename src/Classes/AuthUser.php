<?php

namespace Classes;

use Interfaces\Auth;
use Interfaces\IRequest;
use Interfaces\Model;

class AuthUser implements Auth
{
    private static $authUser;
    private IRequest $request;
    private Model $user;

    private function __construct(IRequest $request, Model $user)
    {
        $this->request = $request;
        $this->user = $user;

    }
    public static function getInstance(IRequest $request, Model $user): AuthUser
    {
        if (null == self::$authUser) {
            self::$authUser = new AuthUser($request, $user);
        }
        return self::$authUser;
    }

    private function auth($login, $password)
    {
        $userId = $this->user->getIdByLoginAndPassword($login, $password);
        if (!empty($userId)) {
            $this->user->load($userId);
        }
        $this->request->setSession('user_id', $this->user->id);
        $this->request->setSession('user_login', $this->user->login);
    }

    public function login()
    {
        if ($this->request->getSessionByKey('user_id') && $this->request->getSessionByKey('user_login')) {
            $this->user->load($this->request->getSessionByKey('user_id'));
        } else {
            $postData = $this->request->getBody();
            $login = empty($postData['login']) ? '' : $postData['login'];
            $password = empty($postData['password']) ? '' : $postData['password'];
            $this->auth($login, $password);
            $this->request->setSession('user_id', $this->user->id);
            $this->request->setSession('user_login', $this->user->login);
        }
    }

    public function register()
    {
        $postData = $this->request->getBody();
        if (empty($postData['login'])) {
            throw new \Exception('Логин не может быть пустым');
        }
        if (empty($postData['password'])) {
            throw new \Exception('Пароль не может быть пустым');
        }

        $this->user->create($postData['login'], $postData['password']);
        $this->auth($postData['login'], $postData['password']);
    }

    public function logout()
    {
        $this->user->clear();
        $this->request->clearSession();
        session_destroy();
        session_write_close();
    }

    public function isAuth(): bool
    {
        if ($this->user->id) {
            return true;
        }
        return false;
    }
    public function getAuthUser(): Model
    {
        return $this->user;
    }
}
