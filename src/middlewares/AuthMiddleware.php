<?php

namespace App\Middlewares;

class AuthMiddleware
{
    public function handle(array $params = []): void
    {
        if (!isset($_GET['token']) || $_GET['token'] !== 'secret') {
            http_response_code(403);
            echo "Access denied.";
            exit;
        }
    }
}
