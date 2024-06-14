<?php
declare(strict_types=1);

namespace App\Model;

class User
{
    public int $id;
    public string $name;
    public string $mail;
    public string $profileUrl;
    private string $password;

    public function __construct(int $id, string $name, string $mail, string $profileUrl, string $password = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->mail = $mail;
        $this->profileUrl = $profileUrl;
        $this->password = $password;
    }

    public function getHashPassword(): string
    {
        return $this->password;
    }
}
