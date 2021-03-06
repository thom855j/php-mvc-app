<?php

namespace MVC\Models;

use MVC\Classes\Model;

class Posts extends Model
{
    protected $table = 'users';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($user = [])
    {
        return $this->db->table($this->table)->insert($user);
    }

    public function read($where = [])
    {
        return $this->db->table($this->table)->select(['*'], $where)->results();
    }

    public function update($user = [], $where = [])
    {
        return $this->db->table($this->table)->update($user, $where);
    }

    public function delete($where = [])
    {
        return $this->db->table($this->table)->delete('id', $where);
    }
}