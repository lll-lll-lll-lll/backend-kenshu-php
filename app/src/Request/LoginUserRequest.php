<?php
declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;

class LoginUserRequest
{
    public string $mail;
    private string $rawPassword;

    public function __construct(array $dollPost)
    {
        $mail = $dollPost['mail'];
        $password = $dollPost['password'];
        $this->validateEmail($mail);

        $this->mail = $mail;
        $this->rawPassword = $password;
    }

    private function validateEmail(mixed $mail): void
    {
        if (empty($mail)) {
            throw new InvalidArgumentException('mail is empty');
        }
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid mail');
        }
    }

    /**
     * ユーザのパスワードを管理しているインスタンスを返す
     */
    public function getRawPassword(): string
    {
        return $this->rawPassword;
    }
}
