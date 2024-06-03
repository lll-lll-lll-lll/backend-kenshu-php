<?php
declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;

class CreateUserRequest
{
    public string $userName;
    public string $mail;
    public string $profileUrl;

    public string $password;

    public function __construct(array $dollPost)
    {
        $userName = $dollPost['user_name'];
        $mail = $dollPost['mail'];
        $password = $dollPost['password'];
        $profileUrl = $dollPost['profile_url'];
        $checkedProfileUrl = $this->setProfileUrl($profileUrl);

        $this->validateEmail($mail);
        $this->validatePassword($password);
        $this->validateUserName($userName);
        $this->validateProfileUrl($checkedProfileUrl);

        $this->profileUrl = $checkedProfileUrl;
        $this->userName = $userName;
        $this->mail = $mail;
        $this->password = $password;
    }

    /**
     * プロフィールURLは任意なので、空文字の場合は空文字を返す
     * @param string $profileUrl
     * @return string
     */
    private function setProfileUrl(string $profileUrl): string
    {
        if (!empty($profileUrl)) {
            return $profileUrl;
        }
        return '';
    }

    private function validateEmail(string $mail): void
    {
        if (empty($mail)) {
            throw new InvalidArgumentException('mail is empty');
        }
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid mail');
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

    private function validateProfileUrl(string $profileUrl): void
    {
        if (!empty($profileUrl) && !filter_var($profileUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL for profile image');
        }
    }
}
