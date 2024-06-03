<?php
declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;

class CreateUserRequest
{
    public string $user_name;
    public string $mail;
    // プロフィール画像は任意なので空文字で初期化
    public string $profile_url;

    public string $password;

    public function __construct(array $dollPost)
    {
        $user_name = $dollPost['user_name'];
        $mail = $dollPost['email'];
        $password = $dollPost['password'];
        $profile_url = $dollPost['profile_url'];

        $this->validateEmail($mail);
        $this->validatePassword($password);
        $this->validateUserName($user_name);
        $this->validateProfileUrl($profile_url);

        $this->profile_url = $profile_url;
        $this->user_name = $user_name;
        $this->mail = $mail;
        $this->password = $password;
    }

    private function validateEmail(string $email): void
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Email is not empty');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }
    }

    private function validatePassword(string $password): void
    {
        if (empty($password)) {
            throw new InvalidArgumentException('Password is not empty');
        }
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password is too short');
        }
    }

    private function validateUserName(string $user_name): void
    {
        if (empty($user_name)) {
            throw new InvalidArgumentException('User name is not empty');
        }
        if (strlen($user_name) > 255) {
            throw new InvalidArgumentException('User name is too long');
        }
    }

    private function validateProfileUrl(string $profile_url): void
    {
        if (!empty($profile_url) && !filter_var($profile_url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('無効なプロフィールURLです');
        }
    }
}
