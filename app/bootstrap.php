<?php

session_start();

define('APSPATH', dirname(__DIR__));

ini_set('display_errors', true);

require_once APSPATH . '/vendor/autoload.php';


$container = new MVC\Classes\Container;

$container->set('Config', new MVC\Classes\Config());
$container->get('Config')->load(APSPATH . '/app/config.php');

$container->set('Errors', new MVC\Classes\Errors);

/*
$container->set('DB', new MVC\Classes\Database($container->get('Config')->get('db')));
$container->set('Validator', new MVC\Classes\Validator(
    $container->get('DB'),
    $container->get('Errors')
));
*/

$container->set('View', new MVC\Classes\View);


$app = new MVC\Classes\App($container);

$app->path = APSPATH . '/app/controllers/';

$app->run();