<?php

//Define Classes
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;


//Loading autoload composer
require_once __DIR__.'/../vendor/autoload.php';

//Loading Env files
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Config array
$config = [
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

//Start Application
$app = new Application(dirname(__DIR__), $config);

$app->onEvent(Application::EVENT_BEFORE_REQUEST, function () {
    echo 'Before Request';
});

//ROUTES
//GET Method
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/profile', [AuthController::class, 'profile']);
$app->router->get('/contact', [SiteController::class, 'contact']);

//POST Method
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->post('/register', [AuthController::class, 'register']);
$app->router->post('/login', [AuthController::class, 'login']);


//Run Application
$app->run();