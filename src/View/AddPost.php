<?php

namespace View;

use Interfaces\View;

class AddPost implements View
{
    private $dir = __DIR__ . '/../../templates/';

    public function render($params = []): string
    {
        $content = file_get_contents($this->dir . 'post_form.html');
        $error = empty( $params['error']) ? '' :  $params['error'];
        $content = str_replace('$error', $error, $content);
        return $content;
    }
}
