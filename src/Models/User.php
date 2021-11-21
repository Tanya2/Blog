<?php

namespace Models;

use Interfaces\Db;
use Interfaces\Model;

class User implements Model
{
    private $db;
    public $login;
    public $id;
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
            "SELECT * FROM user WHERE id = :id",
            [':id' => $id]
        );
        return $data[0];
    }

    public function load($id)
    {
        $data = $this->getById($id);

        if (!empty($data['id']) && !empty($data['login'])) {
            $this->id = $data['id'];
            $this->login = $data['login'];
        }
    }

    public function clear()
    {
        $this->id = null;
        $this->login = null;
    }


    public function getIdByLoginAndPassword($login, $password)
    {
        $data = $this->getData(
            "SELECT id FROM user WHERE login = :login AND password = :password",
            [':login' => $login, ':password' =>  $this->getPassword($password)]
        );

        return empty($data[0]['id']) ? 0 : $data[0]['id'];
    }

    public function create($login, $password): int
    {
        $data = $this->getData(
            "SELECT id FROM user WHERE login = :login ",
            [':login' => $login]
        );
        if (!empty($data[0]['id'])) {
            throw new \Exception('Пользователь с таким логином существует');
        }
        $this->db->exec(
            "INSERT INTO user(id, login, password, token) VALUES (NULL, :login, :password, '')",
            [':login' => $login, ':password' => $this->getPassword($password)]
        );
        return $this->db->getLastInsertId();
    }

    private function getPassword($password)
    {
        return md5($password . 'password');
    }
}
