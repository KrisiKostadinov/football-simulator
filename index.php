<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Router;

use App\Controllers\HomeController;
use App\Controllers\UserController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/users/register', [UserController::class, 'register']);
$router->get('/users/login', [UserController::class, 'login']);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
