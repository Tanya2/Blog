<?php

namespace Models;

use Interfaces\Db;
use Interfaces\Model;

class Post implements Model
{
    private $db;
    public $title;
    public $description;
    public $user_id;
    public $img;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }
    public function getData($sql, $params = [])
    {
        return $this->db->getData($sql, $params);
    }

    public function getById($id)
    {
        $data = $this->db->getData(
            "SELECT p.*, u.login FROM post p
            JOIN user u ON u.id = p.user_id WHERE p.id = :id",
            [':id' => $id]
        );
        return empty($data[0]) ? [] : $data[0];
    }

    public function load($id)
    {
        $data = $this->getById($id);

        if (!empty($data['id']) && !empty($data['login'])) {
            $this->title = $data['title'];
            $this->short_description = $data['short_description'];
            $this->description = $data['description'];
            $this->user_id = $data['user_id'];
            $this->img = $data['img'];
        }
    }

    public function clear()
    {
        $this->title = null;
        $this->description = null;
        $this->user_id = null;
        $this->img = null;
    }
    public function getPosts($query)
    {
        $filter = '';
        $params = [];
        if (!empty($query)) {
            $filter = " WHERE title LIKE :query ";
            $params = [':query' => '%' . $query .'%'];
        }
        $sql = "SELECT p.*, u.login FROM post p
            JOIN user u ON u.id = p.user_id
            " . $filter . " ORDER BY id DESC";
        return $this->getData($sql, $params);
    }

    public function create($postData): int
    {
        if (empty($postData['title'])) {
            throw new \Exception('Заголовок не может быть пустым');
        }
        if (empty($postData['description'])) {
            throw new \Exception('Описание не может быть пустым');
        }
        if (empty($postData['img'])) {
            throw new \Exception('Изображение не может быть пустым');
        }
        if (empty($postData['user_id'])) {
            throw new \Exception('Пользователь не определен');
        }
        $this->db->exec(
            "INSERT INTO post (id, title, description, user_id, img) VALUES (NULL, :title, :description, :user_id, :img)",
            [
                ':title' => $postData['title'],
                ':description' => $postData['description'],
                ':user_id' => $postData['user_id'],
                ':img' => $postData['img']
            ]
        );
        return $this->db->getLastInsertId();
    }
}
