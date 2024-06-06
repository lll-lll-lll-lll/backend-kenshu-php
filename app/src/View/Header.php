<?php
declare(strict_types=1);

namespace App\View;

class Header
{
    public function renderLogin(): string
    {
        return "<a href='/login'>login</a>";
    }

    public function renderLogout(): string
    {
        return "<a href='/logout'>logout</a>";
    }
}
