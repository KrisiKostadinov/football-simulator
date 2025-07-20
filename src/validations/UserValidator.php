<?php

namespace App\Validations;

class UserValidator
{
    public static function validateRegister(array $data): array
    {
        $errors = [];

        if (empty($data['first_name']) || strlen($data['first_name']) < 2) {
            $errors['first_name'] = __('validation_first_name');
        }

        if (empty($data['last_name']) || strlen($data['last_name']) < 2) {
            $errors['last_name'] = __('validation_last_name');
        }

        if (empty($data['username']) || !preg_match('/^[a-zA-Z0-9_-]{3,}$/', $data['username'])) {
            $errors['username'] = __('validation_username');
        }

        if (empty($data['team_name']) || strlen(trim($data['team_name'])) < 2) {
            $errors['team_name'] = __('validation_team_name');
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = __('validation_email');
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors['password'] = __('validation_password');
        }

        if (($data['password'] ?? '') !== ($data['password_confirm'] ?? '')) {
            $errors['password_confirm'] = __('validation_password_confirm');
        }

        return $errors;
    }

    public static function validateLogin(array $data): array
    {
        $errors = [];

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = __('validation_email');
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors['password'] = __('validation_password');
        }

        return $errors;
    }
}
