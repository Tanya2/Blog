<?php

namespace Controllers;

use Classes\Loading;
use Models\Database;

class Post extends Controller
{
    public function posts($requestData): string
    {
        $posts = new \Models\Post(Database::getInstance());
        $params = [
            'posts' => $posts->getPosts($requestData['query'])
        ];
        if (!$this->authUser->isAuth()) {
            $params['navbarRightText'] = 'Зарегистрироваться';
            $params['navbarRightUrl'] = 'register';
            $params['addPost'] = 'invisible';
        }
        return  $this->view->render('Posts', $params);
    }

    public function post($requestData): string
    {
        $posts = new \Models\Post(Database::getInstance());
        $params = [
            'post' => $posts->getById($requestData['id'])
        ];
        if (!$this->authUser->isAuth()) {
            $params['navbarRightText'] = 'Зарегистрироваться';
            $params['navbarRightUrl'] = 'register';
            $params['addPost'] = 'invisible';
        }
        return  $this->view->render('Post', $params);
    }
    public function addPost($requestData = []): string
    {
        $error = '';
        if (!empty($requestData)) {
            try {
                $loading = new Loading('post');
                $requestData['img'] = $loading->upload();
                $posts = new \Models\Post(Database::getInstance());
                $id = $posts->create($requestData);
                return  $this->view->render('Post', ['post' => $posts->getById($id)]);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }

        }
        return  $this->view->render('AddPost', ['error' => $error]);
    }
}
