<?php

namespace MVC\Interfaces;

interface ModelInterface
{
    public function create($table);

    public function read($where);

    public function update($table, $where);

    public function delete($where);
}