<?php
ob_start();

use Classes\Request;
use Interfaces\Auth;
use Interfaces\IRequest;
use Models\Database;
use Models\User;
use Classes\AuthUser;
use Classes\Router;

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once __DIR__ . '/vendor/autoload.php';
session_start();


$user = new User(Database::getInstance());
$request = new Request();
$authUser = AuthUser::getInstance($request, $user);
$router = new Router($request, $authUser);

$router->get('/', function(IRequest $request, Auth $authUser) {
    $authUser->login();
    echo (new \Controllers\Post($authUser))->posts(['query' => $request->getQuery('query')]);
});

$router->get('/read', function(IRequest $request, Auth $authUser) {
    $authUser->login();
    echo (new \Controllers\Post($authUser))->post(['id' => $request->getQuery('id')]);
});
$router->get('/post', function(IRequest $request, Auth $authUser) {
    $authUser->login();
    if (!$authUser->isAuth()) {
        header( "Location: /login" );
    }
    echo (new \Controllers\Post($authUser))->addPost();
});
$router->post('/post', function(IRequest $request, Auth $authUser) {
    $authUser->login();
    if (!$authUser->isAuth()) {
        header( "Location: /login" );
    }
    $postData = $request->getBody();
    $postData['user_id'] = $authUser->getAuthUser()->id;
    echo (new \Controllers\Post($authUser))->addPost($postData);
});

$router->get('/register', function(IRequest $request, Auth $authUser) {
    $authUser->login();
    if ($authUser->isAuth()) {
        header( "Location: /" );
    }
    echo (new \Controllers\User($authUser))->register();
});
$router->post('/register', function(IRequest $request, Auth $authUser) {
    $error = 'Ошибка регистрации';
    try {
        $authUser->register();
    } catch (\Throwable $e) {
        $error = $e->getMessage();
    }
    if ($authUser->isAuth()) {
        header( "Location: /" );
    }
    echo (new \Controllers\User($authUser))->register(['error' => $error]);

});

$router->get('/login', function(IRequest $request, Auth $authUser) {
    $authUser->login();
    if ($authUser->isAuth()) {
        header( "Location: /" );
    }
    echo (new \Controllers\User($authUser))->login();

});
$router->post('/login', function(IRequest $request, Auth $authUser) {
    $authUser->login();
    if ($authUser->isAuth()) {
        header( "Location: /" );
    }
    echo (new \Controllers\User($authUser))->login(['error' => true]);
});

$router->get('/logout', function(IRequest $request, Auth $authUser) {
    $authUser->logout();
    header( "Location: /login" );
});

ob_end_flush();