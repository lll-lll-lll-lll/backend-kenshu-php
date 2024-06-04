<?php
declare(strict_types=1);

namespace App\Model;

class User
{
    public int $id;
    public string $name;
    public string $mail;
    public string $profileUrl;
    public string $createdAt;
    public string $updatedAt;
    private string $hashPassword;

    public function __construct(int $id, string $name, string $mail, string $password, string $profileUrl, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mail = $mail;
        $this->hashPassword = $password;
        $this->profileUrl = $profileUrl;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getHashPassword(): string
    {
        return $this->hashPassword;
    }
}
