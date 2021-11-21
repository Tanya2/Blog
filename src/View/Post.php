<?php

namespace View;

use Interfaces\View;

class Post implements View
{
    public function render($post = []): string
    {
        if (empty($post['post'])) {
            return 'Статья не найдена';
        }
        $content = "<div class='post-container'><h1 class='main-title text-center'>{$post['post']['title']}</h1>";
        $content .= "<div class='card col-sm-12'>               
            <div class='postimg'>
              <img src='/{$post['post']['img']}' class='card-img-top' alt=''>
            </div>
            <div class='card-body'>                
                <p class='card-text'>{$post['post']['description']}</p>
                <p class='card-login '>{$post['post']['login']}</p>                    
            </div>
        </div>";

        return $content . '</div>';
    }
}
