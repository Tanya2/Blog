<?php

namespace View;

use Interfaces\View;

class Auth implements View
{
    private $dir = __DIR__ . '/../../templates/';

    public function render($params = []): string
    {
        $content = file_get_contents($this->dir . 'auth_form.html');
        $error = empty( $params['error']) ? '' :  $params['error'];
        $content = str_replace('$error', $error, $content);
        $formButtonText = empty( $params['formButtonText']) ? '' :  $params['formButtonText'];
        $content = str_replace('$formButtonText', $formButtonText, $content);
        $formUrl = empty( $params['formUrl']) ? '' :  $params['formUrl'];
        $content = str_replace('$formUrl', $formUrl, $content);
        return $content;
    }
}
