<?php

require __DIR__ . '/vendor/autoload.php';

use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
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
$router->get('/users/register', [UserController::class, 'register'], [GuestMiddleware::class]);
$router->get('/users/login', [UserController::class, 'login'], [GuestMiddleware::class]);
$router->get('/users/logout', [UserController::class, 'logout'], [AuthMiddleware::class]);
$router->get('/users/forgot-password', [UserController::class, 'forgotPassword'], [GuestMiddleware::class]);
$router->get('/users/change-password/{token}', [UserController::class, 'changePassword'], [GuestMiddleware::class]);

$router->post('/users/register', [UserController::class, 'registerAction']);
$router->post('/users/login', [UserController::class, 'loginAction']);
$router->post('/users/forgot-password', [UserController::class, 'forgotPasswordAction']);
$router->post('/users/change-password', [UserController::class, 'changePasswordAction']);

session_start();

$userController = new UserController();

$userController->isAuthenticated();

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
