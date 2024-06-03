<?php
declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;

class CreateUserRequest
{
    public string $userName;
    public string $mail;
    // プロフィール画像は任意なので空文字で初期化
    public string $profile_url;

    public string $password;

    /**
     * @param array<string, string> $body
     */
    public function __construct(array $body)
    {
        $userName = $body['user_name'];
        $mail = $body['mail'];
        $profileUrl = $body['profile_url'];
        $password = $body['password'];
        $this->validateEmail($mail);
        $this->validatePassword($password);
        $this->validateUserName($userName);
        $this->validateProfileUrl($profileUrl);

        $this->profile_url = $profileUrl;
        $this->userName = $userName;
        $this->mail = $mail;
        $this->password = $password;
    }

    private function validateEmail(string $mail): void
    {
        if (empty($mail)) {
            throw new InvalidArgumentException('Email is not empty');
        }
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
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

    private function validateUserName(string $userName): void
    {
        if (empty($userName)) {
            throw new InvalidArgumentException('User name is not empty');
        }
        if (strlen($userName) > 255) {
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
