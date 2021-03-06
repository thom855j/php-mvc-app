<?php

namespace MVC\Classes;

use MVC\Classes\Container;
use MVC\Interfaces\ControllerInterface;

abstract class Controller implements ControllerInterface
{
    protected $app;

    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    public function __get($property) 
    {
        if ($this->app->get($property)) {
            return $this->app->get($property);
        }
    }

    public function index()
    {

    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

    public function destroy($id)
    {

    }

    public function delete()
    {
        
    }

}