<?php
declare(strict_types=1);

namespace App\Model;

use DateTime;

class User
{
    public int $id;
    public string $name;
    public string $mail;
    public UserPassword $password;
    public string $profileURL;
    public DateTime $createdAt;

    public function __construct(int $id, string $name, string $mail, UserPassword $password, string $profileURL, DateTime $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mail = $mail;
        $this->password = $password;
        $this->profileURL = $profileURL;
        $this->createdAt = $createdAt;
    }

}
