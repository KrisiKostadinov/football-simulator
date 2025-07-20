<?php

namespace App\Middlewares;

use App\Controllers\UserController;

class GuestMiddleware
{
    public function handle(array $params = []): void
    {
        $userController = new UserController();

        if ($userController->isAuthenticated()) {
            header('Location: /');
            exit;
        }
    }
}
