<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\core\Application;

$app = new Application();

$app->router->get('/', 'Start page');
$app->router->get('/contact', function() {
    echo "Page contact";
});

$app->run();