<?php

namespace Interfaces;

interface View
{
    public function render($params = []): string;
}
