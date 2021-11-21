<?php

namespace Controllers;

use Interfaces\Auth;
use View\View;

class Controller
{
    protected $view;
    protected $authUser;
    public function __construct(Auth $authUser)
    {
        $this->view = new View();
        $this->authUser = $authUser;
    }
}
