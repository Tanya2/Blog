<?php

namespace Interfaces;

interface Auth
{
    public function login();
    public function logout();
    public function isAuth(): bool;
    public function getAuthUser(): Model;
}
