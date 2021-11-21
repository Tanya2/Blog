<?php

namespace Classes;

use Interfaces\IRequest;

class Request implements IRequest
{
    private $currentUser;
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {

        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);
        preg_match_all('/_[a-z]/', $result, $matches);

        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public function getQuery($queryKey = '')
    {
        if($this->requestMethod === "GET")
        {
            foreach($_GET as $key => $value)
            {
                if ($queryKey == $key) {
                    return htmlspecialchars($value);
                }
            }
            return '';
        }
    }

    public function getBody()
    {
        if($this->requestMethod === "GET")
        {
            return;
        }

        if ($this->requestMethod == "POST")
        {
            $body = array();
            foreach($_POST as $key => $value)
            {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }
    public function getAuthUser()
    {
        return $this->currentUser;
    }

    public function getSessionByKey(string $key)
    {
        return !empty($_SESSION) && array_key_exists($key, $_SESSION) ? $_SESSION[$key] :  '';
    }
    public function setSession(string $key, $value) :bool
    {
        if (isset($_SESSION)) {
            $_SESSION[$key] = $value;
            return true;
        }
        return  false;
    }
    public function clearSession()
    {
        $_SESSION = [];
    }
}
