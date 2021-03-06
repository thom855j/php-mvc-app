<?php

namespace MVC\Classes;

use MVC\Classes\Database;
use MVC\Interfaces\ModelInterface;

abstract class Model implements ModelInterface
{
    protected $db;

    public function __construct(Database $db) 
    {
        $this->db = $db;
    }

    public function create($table = [])
    {
 
    }

    public function read($where = [])
    {

    }

    public function update($table = [], $where = [])
    {

    }

    public function delete($where = [])
    {

    }
}