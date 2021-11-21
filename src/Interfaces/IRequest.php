<?php

namespace Interfaces;

interface IRequest
{
    public function getBody();
    public function getAuthUser();
    public function getSessionByKey(string $key);
    public function setSession(string $key, $value);
    public function clearSession();
}
