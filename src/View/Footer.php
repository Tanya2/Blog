<?php

namespace View;
use Interfaces\View;

class Footer implements View
{
    private $dir = __DIR__ . '/../../templates/';

    public function render($params = []): string
    {
        return $this->footer() . "                          
            </body>
            </html>
        ";
    }

    private function footer(): string
    {
        return file_get_contents($this->dir . 'footer.html');
    }
}