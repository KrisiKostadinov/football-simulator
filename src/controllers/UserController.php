<?php

namespace App\Controllers;

use Core\Database;
use Core\JwtHelper;
use Core\MailService;
use App\Validations\UserValidator;
use App\Repositories\UserRepository;
use Core\Router;
use Core\View;

require_once dirname(__DIR__) . '/helpers/languages.php';


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

    public function forgotPassword()
    {
        View::render('users/forgot_password', ['title' => __('forgot_password_title')]);
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

        $emailExists = $this->userRepository->findByEmail($formData['email']);
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
            header('Location: /users/login');
            exit;
        }

        return View::render('users/register', [
            'title' => __('register_title'),
            'errors' => ['general' => __('register_failed')],
            'old' => $formData
        ]);
    }

    public function loginAction()
    {
        $formData = $_POST;
        $errors = UserValidator::validateLogin($formData);

        if (!empty($errors)) {
            return View::render('users/login', [
                'title' => __('login_title'),
                'errors' => $errors,
                'old' => $formData
            ]);
        }

        $user = $this->userRepository->findByEmail($formData['email']);

        if (!$user || !password_verify($formData['password'], $user['password'])) {
            $errors['general'] = __('invalid_credentials');
            return View::render('users/login', [
                'title' => __('login_title'),
                'errors' => $errors,
                'old' => $formData
            ]);
        }

        $jwt_secret_key = $_ENV['JWT_SECRET'];
        $jwt_expiration = $_ENV['JWT_EXPIRATION'];

        $token = JwtHelper::encode([
            'user_id' => $user['id'],
            'password' => $user['password'],
            'exp' => time() + $jwt_expiration
        ], $jwt_secret_key);

        $_SESSION['token'] = $token;
        unset($_SESSION['user']);
        header('Location: /');
        exit;
    }

    public function forgotPasswordAction()
    {
        $formData = $_POST;
        $errors = UserValidator::validateForgotPassword($formData);

        if (!empty($errors)) {
            return View::render('users/forgot_password', [
                'title' => __('forgot_password_title'),
                'errors' => $errors,
                'old' => $formData
            ]);
        }

        $user = $this->userRepository->findByEmail($formData['email']);

        if (!$user) {
            $errors['email'] = __('email_not_found');
            return View::render('users/forgot_password', [
                'title' => __('forgot_password_title'),
                'errors' => $errors,
                'old' => $formData
            ]);
        }

        $token = bin2hex(random_bytes(32));
        $resetLink = Router::getDomain() . '/reset-password?token=' . $token;
        $this->userRepository->savePasswordResetToken($token, $user['id']);

        $html = MailService::renderTemplatePlaceholders(
            file_get_contents(dirname(__DIR__) . '/views/email-templates/forgot-password-bg.php'),
            [
                'website_name' => __('website_title'),
                'first_name' => $user['first_name'],
                'reset_link' => $resetLink
            ]
        );

        $mail = new MailService();
        $result = $mail->send($user['email'], __('forgot_password_title'), $html);

        if ($result) {
            $_SESSION['message_success'] = __('forgot_password_sent');
            header('Location: /users/login');
            exit;
        } else {
            $_SESSION['message_error'] = __('email_send_failed');
            return View::render('users/forgot_password', [
                'title' => __('forgot_password_title'),
                'errors' => ['email' => __('email_send_failed')],
                'old' => $formData
            ]);
        }
    }

    public function isAuthenticated(): bool
    {
        if (empty($_SESSION['token'])) {
            return false;
        }

        try {
            $decoded = JwtHelper::decode($_SESSION['token'], $_ENV['JWT_SECRET']);

            if (!$decoded) {
                $this->logout();
                return false;
            }

            $user = $this->userRepository->findById($decoded['user_id']);

            $_SESSION['user'] = $user;
            return true;
        } catch (\Exception $e) {
            unset($_SESSION['token']);
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['token']);
        unset($_SESSION['user']);
        header('Location: /users/login');
        exit;
    }
}
