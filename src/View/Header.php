<?php

namespace View;

use Interfaces\View;

class Header implements View
{
    private $dir = __DIR__ . '/../../templates/';

    public function render($params = []): string
    {
        return $this->head() . $this->header($params);
    }

    private function head()
    {
        return "
            <!doctype html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <title>Document</title>
                <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC\" crossorigin=\"anonymous\">
                <link rel=\"stylesheet\" href=\"css/post.css\">
            </head>
            <body>
        ";
    }

    private function header($params)
    {
        $content = file_get_contents($this->dir . 'navbar.html');
        $navbarRightText = empty( $params['navbarRightText']) ? 'Выйти' :  $params['navbarRightText'];
        $content = str_replace('$navbarRightText', $navbarRightText, $content);
        $navbarRightUrl = empty( $params['navbarRightUrl']) ? 'logout' :  $params['navbarRightUrl'];
        $content = str_replace('$navbarRightUrl', $navbarRightUrl, $content);
        $addPost = empty( $params['addPost']) ? '' :  $params['addPost'];
        $content = str_replace('$addPost', $addPost, $content);
        return $content;
    }
}
