<?php

namespace MVC\Classes;

class Container
{
    // object instance
    protected static $instance = null;

    protected $data;

    // singleton instance
    public static function singleton()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Container();
        }

        return self::$instance;
    }

    public function set($id, $input)
    {
        return $this->data[$id] = $input;
    }

    public function has($id)
    {
        return $this->get($id);
    }

    public function get($id, $default = null)
    {
        $index = explode('.', $id);
        $data = $this->getValue($index, $this->data);

        if ($data) {
            return $data;
        }

        return false;
    }

    /**
    * @param array      $id
    * @param int|string $position
    * @param mixed      $value
    */
    public function add($id, $value, $position = 1)
    {
        if (is_int($position)) {
            return array_splice($this->data[$id], $position, 0, $value);
        } else {
            $pos   = array_search($position, array_keys($this->data[$id]));

            return $this->data[$id] = array_merge(
                   array_slice($this->data[$id], 0, $pos),
                   $value,
                   array_slice($this->data[$id], $pos)
            );
        }
    }

    private function getValue($index, $value)
    {
        if (is_array($index) && count($index)) {
            $current_index = array_shift($index);
        }

        if (is_array($index) &&
            count($index) &&
            isset($value[$current_index]) &&
            is_array($value[$current_index]) &&
            count($value[$current_index])) {
            return $this->getValue($index, $value[$current_index]);
        } elseif (isset($value[$current_index])) {
            return $value[$current_index];
        } else {
            return false;
        }
    }
}