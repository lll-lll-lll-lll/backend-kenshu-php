<?php
declare(strict_types=1);

namespace App\UseCase\User;

use App\Auth\Cookie;
use App\Auth\Session;

class LogoutUseCase
{
    public function __construct()
    {
    }

    public function execute(): void
    {
        Session::clean();
        Cookie::unSetCookie(Session::SESSION_ID_KEY, '');
    }
}
