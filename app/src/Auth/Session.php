<?php
declare(strict_types=1);

namespace App\Auth;

class Session
{
    // セッションの有効期限を設定. 7日間
    const int TIME_OUT = 7 * 24 * 60 * 60;

    const string SESSION_ID_KEY = 'PHPSESSID';
    const string USER_ID_KEY = 'user_id';
    const string EXPIRES_KEY = 'expires';
    const string TIME_OUT_KEY = 'timeout';

    public static function start(): void
    {
        session_start();
    }

    public static function clean(): void
    {
        if (!session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION = array();
        session_regenerate_id(true);
    }

    /**
     * セッションの有効期限を設定する
     * @param int $userId
     * @return void
     */
    public static function setSession(int $userId): void
    {
        if (!session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION[self::USER_ID_KEY] = $userId;
        $_SESSION[self::TIME_OUT_KEY] = self::TIME_OUT;
        $_SESSION[self::EXPIRES_KEY] = time() + self::TIME_OUT;
    }

    /**
     * セッションが有効期限切れかどうかを判定する
     * @return bool 有効期限切れの場合true
     */
    public static function isSessionExpired(): bool
    {
        if (!session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        // セッションが存在しない場合は有効期限が切れているものとする。
        if (!isset($_SESSION[self::EXPIRES_KEY])) {
            return true;
        }
        return $_SESSION[self::EXPIRES_KEY] < time();
    }

    public static function has(string $key): bool
    {
        if (!session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        return isset($_SESSION[$key]);
    }

    public static function get(string $key): mixed
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        return $_SESSION[$key];
    }
}
