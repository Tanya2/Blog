<?php

namespace View;
use Interfaces\View;

class Posts implements View
{
    public function render($params = []): string
    {
        $content = "<div class='post-container'><h1 class='main-title text-center'>Красивые места мира</h1>";
        foreach ($params['posts'] as $post) {
            $description = substr($post['description'], 0, 250) . '...';
            $content .= "<div class='card col-sm-12'>               
                <div class='postimg'>
                  <img src='/{$post['img']}' class='card-img-top' alt=''>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>{$post['title']}</h5>
                    <p class='card-text'>{$description}</p>
                    <p class='card-login '>{$post['login']}</p>
                    <a href='/read?id={$post['id']}' class='btn btn-outline-info'>Подробнее</a>
                </div>
            </div>";
        }
        return $content . '</div>';
    }
}
