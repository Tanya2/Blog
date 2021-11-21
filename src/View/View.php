<?php

namespace View;

class View
{
    public function render($name, $params = []): string
    {
        $head = (new \View\Header())->render($params);
        $name = 'View\\' . $name;
        $obj = new $name();
        $content = "<div class=\"row\" style='min-height:300px; padding-left: 30px'>
            {$obj->render($params)}
        </div>";
        $footer = (new \View\Footer())->render();
        return $head . $content . $footer;
    }
}
