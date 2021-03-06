<?php

//Define Classes
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;


//Loading autoload composer
require_once __DIR__.'/vendor/autoload.php';

//Loading Env files
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Config array
$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

//Start Application
$app = new Application(__DIR__, $config);
$app->db->applyMigrations();