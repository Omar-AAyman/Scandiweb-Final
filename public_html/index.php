<?php


use app\Core\App;
use Dotenv\Dotenv;
use app\Controllers\ProductController;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv=Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();


$config= [
    'db'=>[
        'hostName' => $_ENV['DB_HOSTNAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'database' => $_ENV['DB_NAME'],
        'port' => $_ENV['DB_PORT'],
    ],
];
$app = new App(dirname(__DIR__) , $config);

$app->router->get('/', [ProductController::class , 'productsList']);
$app->router->get('/add-product', [ProductController::class , 'addProduct']);
$app->router->post('/add-product', [ProductController::class , 'addProduct']);

$app->router->post('/mass-delete', [ProductController::class , 'deleteProduct']);
$app->router->get('/mass-delete', [ProductController::class , 'deleteProduct']);


$app->run();
   