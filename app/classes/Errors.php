<?php

namespace MVC\Classes;

class Errors
{
    protected $errors = [];

    public function set($error, $key = null)
    {
        if($key) {
            $this->errors[$key][] = $error;
        } else {

        }
    }

    public function get($key = null)
    {
        return isset($this->errors[$key]) ? $this->errors[$key] : $this->errors;
    }

    public function exists()
    {
        return count($this->get()) ? true : false;
    }

    public function first($key)
    {
        return isset($this->get()[$key][0]) ? $this->get()[$key][0] : false;
    }
}