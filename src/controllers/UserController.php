<?php

namespace App\Controllers;

require_once dirname(__DIR__) . '/helpers/languages.php';

use Core\View;

class UserController
{
    public function register() {
        View::render('users/register', ['title' => __('register_title')]);
    }

    public function login() {
        View::render('users/login', ['title' => __('login_title')]);
    }
}
