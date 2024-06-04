<?php
declare(strict_types=1);

namespace App\Request;

use App\Model\UserPassword;
use InvalidArgumentException;

class LoginUserRequest
{
    public string $mail;
    private UserPassword $userPassword;

    public function __construct(array $dollPost)
    {
        $mail = $dollPost['mail'];
        $password = $dollPost['password'];
        $this->validateEmail($mail);

        $this->mail = $mail;
        $this->userPassword = new UserPassword($password);
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
    public function getUserPassword(): UserPassword
    {
        return $this->userPassword;
    }
}
