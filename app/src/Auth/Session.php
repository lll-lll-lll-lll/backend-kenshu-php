<?php
declare(strict_types=1);

namespace App\Auth;

class Session
{
    // セッションの有効期限を設定. 7日間
    const int TIME_OUT = 7 * 24 * 60 * 60;

    const string ID_KEY = 'session_id';
    const string USER_ID_KEY = 'user_id';
    const string EXPIRES_KEY = 'expires';
    const string TIME_OUT_KEY = 'timeout';

    public static function start(): void
    {
        session_start();
    }

    /**
     * CSRF脆弱性の対策としてセッションIDと$_POSTに含まれるトークンを検証する。
     * @param array<string, string|bool> $session
     */
    public static function checkTokenAndSessionId(string $token): bool
    {
        return hash_equals($token, session_id());
    }

    public static function clean(): void
    {
        $_SESSION = array();
        session_destroy();
    }

    /**
     * セッションの有効期限を設定する
     * @param int $userId
     * @return array
     */
    public static function setSession(int $userId): void
    {
        session_regenerate_id(true);
        $_SESSION[Session::USER_ID_KEY] = $userId;
        $_SESSION[Session::TIME_OUT_KEY] = Session::TIME_OUT;
        $_SESSION[Session::EXPIRES_KEY] = time() + Session::TIME_OUT;
    }

    public static function isSessionExpired(): bool
    {
        if ($_SESSION[Session::EXPIRES_KEY] < time()) {
            return false;
        }
        return true;
    }
}
