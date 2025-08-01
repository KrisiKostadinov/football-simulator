<?php

namespace App\Middlewares;

use App\Controllers\UserController;

class AuthMiddleware
{
    public function handle(array $params = []): void
    {
        $userController = new UserController();

        if (!$userController->isAuthenticated()) {
            header('Location: /users/login');
            exit;
        }
    }
}
