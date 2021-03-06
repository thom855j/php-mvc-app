<?php

namespace MVC\Classes;

class Config
{
    protected $data;

    protected $default;

    public function load($file)
    {
        $this->data = require $file;
    }

    public function get($key, $default = null)
    {
        $this->default = $default;

        $segments = explode('.', $key);
        $data = $this->data;

        foreach($segments as $segment) {
            if(isset($data[$segment])) {
                $data = $data[$segment];
            } else {
                $data = $this->default;
                break;
            }
        }

        return $data;
    }
}