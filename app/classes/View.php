<?php

namespace MVC\Classes;

class View
{
    public function render($view, $data = [])
    {
        require_once "../app/views/{$view}.php";
    }
}