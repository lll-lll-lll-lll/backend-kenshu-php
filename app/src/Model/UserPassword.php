<?php
declare(strict_types=1);

namespace App\Model;

use InvalidArgumentException;

class UserPassword
{
    private string $hashPassword;
    private string $rawPassword;

    public function __construct(string $password)
    {
        if (empty($password)) {
            throw new InvalidArgumentException('Password is required');
        }
        $this->rawPassword = $password;
        $this->hashPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getHashPassword(): string
    {
        return $this->hashPassword;
    }

    public function getRawPassword(): string
    {
        return $this->rawPassword;
    }
}
