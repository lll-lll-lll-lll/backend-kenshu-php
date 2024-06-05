<?php
declare(strict_types=1);

namespace App\Auth;

class Cookie
{
    public function __construct()
    {
    }

    public static function setCookie(string $key, string $value): bool
    {
        $options = [
            'expires' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax',
        ];

        return setcookie($key, $value, [
            'expires' => $options['expires'],
            'path' => $options['path'],
            'domain' => $options['domain'],
            'secure' => $options['secure'],
            'httponly' => $options['httponly'],
            'samesite' => $options['samesite'],
        ]);
    }
}

