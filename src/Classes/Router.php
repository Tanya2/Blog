<?php

namespace Classes;

use Interfaces\Auth;
use Interfaces\IRequest;

class Router
{
    private IRequest $request;
    private Auth $authUser;
    private $supportedHttpMethods = [
        "GET",
        "POST"
    ];
    private $route = [
        '/',
        '/register',
        '/login',
        '/post',
        '/read',
        '/logout'
    ];

    function __construct(IRequest $request, Auth $authUser)
    {
        $this->request = $request;
        $this->authUser = $authUser;
    }

    function __call($name, $args)
    {
        list($route, $method) = $args;

        if(!in_array(strtoupper($name), $this->supportedHttpMethods))
        {
            $this->invalidMethodHandler();
        }
        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        $resultTtrimParams = explode('?', $result);
        if ($result === '' || !in_array($resultTtrimParams[0], $this->route))
        {
            return '/';
        }
        return $resultTtrimParams[0];
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);

        if(empty($methodDictionary[$formatedRoute]))
        {
            $formatedRoute = '/';
        }
        $method = $methodDictionary[$formatedRoute];
        echo call_user_func_array($method, array($this->request, $this->authUser));
    }

    function __destruct()
    {
        $this->resolve();
    }
}
