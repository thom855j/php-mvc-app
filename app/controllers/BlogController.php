<?php

use MVC\Classes\Controller;

use MVC\Models\Posts;

class BlogController extends Controller
{

    public function __construct($container)
    {
        $this->app = $container;

    }

    public function index()
    {
        $posts = '';
       //$posts = new Posts($this->DB)->read();
        
        $this->View->render('blog/index', $posts);
    }
}