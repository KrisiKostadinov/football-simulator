<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Database;
use Core\Router;
use Dotenv\Dotenv;

use App\Controllers\HomeController;
use App\Controllers\UserController;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = Database::getInstance()->getConnection();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/users/register', [UserController::class, 'register']);
$router->get('/users/login', [UserController::class, 'login']);

$router->post('/users/register', [UserController::class, 'registerAction']);
$router->post('/users/login', [UserController::class, 'loginAction']);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
