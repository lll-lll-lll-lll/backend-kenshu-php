<?php
declare(strict_types=1);

namespace App\View;

class LogoutView
{
    public function execute(): string
    {
        return $this->logoutButton();
    }

    private function logoutButton(): string
    {
        return "<form method='post' action='/api/logout'>
                    <button type='submit'>ログアウト</button>
                </form>";
    }
}
