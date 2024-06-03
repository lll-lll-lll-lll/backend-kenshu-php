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
        $userMame = $dollPost['user_name'];
        $mail = $dollPost['mail'];
        $password = $dollPost['password'];
        $profile_url = $dollPost['profile_url'];
        $checkedProfileUrl = $this->setProfileUrl($profile_url);

        $this->validateEmail($mail);
        $this->validatePassword($password);
        $this->validateUserName($userMame);
        $this->validateProfileUrl($checkedProfileUrl);

        $this->profileUrl = $checkedProfileUrl;
        $this->userName = $userMame;
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

    private function validateEmail(string $email): void
    {
        if (empty($email)) {
            throw new InvalidArgumentException('mail is not empty');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
