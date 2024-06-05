<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Auth\Session;

class CheckLoginStatus
{
    public function __construct()
    {
    }

    /**
     *
     * @return bool ログインしている場合true
     */
    public static function isLogin(array $session, array $cookie): bool
    {
        if (!is_null($session[Session::USER_ID_KEY])) {
            return false;
        }
        if ($cookie[Session::SESSION_ID_KEY] !== session_id()) {
            return false;
        }
        if (!Session::isSessionExpired()) {
            Session::clean();
            return false;
        }
        return true;
    }
}
