<?php

namespace Interfaces;

interface Model
{
    public function getData($sql, $params = []);
    public function getById($id);
    public function load($id);
    public function clear();
}