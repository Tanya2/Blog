<?php

namespace Models;

use Interfaces\Db;

class Database implements Db
{
    private $connect = null;
    private static $database = null;

    private function __construct()
    {
        $this->createConnection();
    }

    private function createConnection()
    {
        if (!$this->connect) {
            $dbname   = getenv('MYSQL_DATABASE');
            $host     = getenv('MYSQL_HOST');
            $user     = getenv('MYSQL_USER');
            $pass     = getenv('MYSQL_PASSWORD');
            $this->connect = new \PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $user, $pass);
            $this->connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function getInstance(): Database
    {
        if (null == self::$database) {
            self::$database = new Database();
        }
        return self::$database;
    }

    public function query($sql)
    {
        return $this->connect->query($sql);
    }

    public function exec($sql, $params = [])
    {
        $sth = $this->connect->prepare($sql);
        foreach ($params as $key => &$val) {
            $sth->bindParam($key, $val);
        }
        $sth->execute();
        return $sth;
    }

    public function getData($query, $param = [], $limit = null, $offset = 0): array
    {
        $sth = $this->exec($query, $param);
        $res = [];
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        $sth->closeCursor();
        return $res;
    }
    public function getLastInsertId(): int
    {
        return $this->connect->lastInsertId();
    }
}
