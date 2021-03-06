<?php

namespace MVC\Classes;

class Validator
{
    protected $db;

    protected $errors;

    protected $items;

    protected $rules = [
        'required', 
        'min', 
        'max', 
        'email',
        'alnum',
        'match',
        'unique'
    ];

    public $messages = [
        'required' => 'The :field field is required',
        'min' => 'The :field field must be a minimum of :check length',
        'max' => 'The :field field must be a maximum of :check length',
        'email' => 'That is not a valid email address',
        'alnum' => 'The :field field must be only letters and numbers',
        'match' => 'The :field field must match the :check field',
        'unique' => 'That :field is already taken'
    ];

    public function __construct(Database $db, Errors $errors)
    {
        $this->db = $db;
        $this->errors = $errors;
    }

    public function validate($items, $rules)
    {
        $this->items = $items;

        foreach($items as $item => $value)
        {
            if(in_array($item, array_keys($rules))) {
                $this->check([
                    'field' => $item,
                    'value' => $value,
                    'rules' => $rules[$item]
                ]);
            }
        }

        return $this;
    }

    public function fails()
    {
        return $this->errors->exists();
    }

    public function errors()
    {
        return $this->errors;
    }

    protected function check($item)
    {
        $field = $item['field'];

        foreach($item['rules'] as $rule => $check) {
            if(in_array($rule, $this->rules)) {
                if(!call_user_func_array([$this, $rule], [$field, $item['value'], $check])) {
                    $this->errors->set(
                        str_replace([':field', ':check'], [$field, $check], $this->messages[$rule]),
                        $field
                    );
                }
            }
        }
    }

    protected function required($field, $value, $check)
    {
        return !empty(trim($value));
    }

    protected function min($field, $value, $check)
    {
        return mb_strlen($value) >= $check;
    }

    protected function max($field, $value, $check)
    {
        return mb_strlen($value) <= $check;
    }

    protected function email($field, $value, $check)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function alnum($field, $value, $check)
    {
        return ctype_alnum($value);
    }

    protected function match($field, $value, $check)
    {
        return $value === $this->items[$check];
    }

    protected function unique($field, $value, $check)
    {
        return !$this->db->table($check)->exists($field, '=', $value);
    }
}