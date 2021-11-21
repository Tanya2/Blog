<?php

namespace Interfaces;

interface Db
{
    public function query($sql);
    public function exec($sql, $params = []);
    public function getData($query, $param = []): array;
    public function getLastInsertId(): int;
}
