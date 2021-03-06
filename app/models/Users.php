<?php

class Users extends Model
{
    protected $table = 'users';

    public function create($user = [])
    {
        return $this->db->table($this->table)->insert($user);
    }

    public function read()
    {
        return $this->db->table($this->table)->select(['*'])->results();
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