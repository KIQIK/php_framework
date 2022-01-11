<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\core\Application;
use app\controllers\SiteController;

$app = new Application(__DIR__);


//GET Method
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->get('/login', [AuthController::class, 'login']);

//POST Method
$app->router->post('/contact', [SiteController::class, 'handelContact']);

$app->router->post('/register', [AuthController::class, 'register']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->run();