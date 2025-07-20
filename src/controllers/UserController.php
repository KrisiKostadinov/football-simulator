<?php

namespace App\Controllers;

use Core\Database;
use App\Validations\UserValidator;
use App\Repositories\UserRepository;

require_once dirname(__DIR__) . '/helpers/languages.php';

use Core\View;

class UserController
{
    private $db;
    private $userRepository;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->userRepository = new UserRepository($this->db);
    }

    public function register()
    {
        View::render('users/register', ['title' => __('register_title')]);
    }

    public function login()
    {
        View::render('users/login', ['title' => __('login_title')]);
    }

    public function registerAction()
    {
        $formData = $_POST;
        $errors = UserValidator::validateRegister($formData);

        if (!empty($errors)) {
            return View::render('users/register', [
                'title' => __('register_title'),
                'errors' => $errors,
                'old' => $formData
            ]);
        }

        $isFirstUser = $this->userRepository->countUsers() === 0;
        $formData['role'] = $isFirstUser ? 'admin' : 'user';

        $emailExists    = $this->userRepository->findByEmail($formData['email']);
        $usernameExists = $this->userRepository->findByUsername($formData['username']);
        $teamNameExists = $this->userRepository->findByTeamName($formData['team_name'] ?? '');

        if ($emailExists) {
            $errors['email'] = __('email_exists');
        }

        if ($usernameExists) {
            $errors['username'] = __('username_exists');
        }

        if ($teamNameExists) {
            $errors['team_name'] = __('team_name_exists');
        }

        if (!empty($errors)) {
            return View::render('users/register', [
                'title' => __('register_title'),
                'errors' => $errors,
                'old' => $formData
            ]);
        }

        if ($this->userRepository->create($formData)) {
            $_SESSION['message_success'] = __('register_success');
            header('Location: /users/login');
            exit;
        }

        return View::render('users/register', [
            'title' => __('register_title'),
            'errors' => ['general' => __('register_failed')],
            'old' => $formData
        ]);
    }
}
