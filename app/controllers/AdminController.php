<?php

use MVC\Classes\Controller;


class AdminController extends Controller
{

    public function __construct($container)
    {
        $this->app = $container;

        if(!$_SESSION['user']) {
            echo 'test';
        }

    }

    public function index()
    {

    }
}