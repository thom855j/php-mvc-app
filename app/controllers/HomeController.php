<?php

class HomeController extends Controller
{
    public function index()
    {
        var_dump($this->model('Users'));
    }
}