<?php

require_once '../app/classes/App.php';
require_once '../app/classes/Controller.php';
require_once '../app/classes/Database.php';
require_once '../app/classes/Model.php';

$app = new App(new Database);

$app->path = __DIR__ . '/controllers/';

$app->run();