<?php

use MVC\Classes\Controller;

class ErrorController extends Controller
{
    public function index() {
        $this->View->render('error/404');
    }

}