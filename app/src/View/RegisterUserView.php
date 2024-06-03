<?php
declare(strict_types=1);

namespace App\View;

class RegisterUserView
{
    public function __construct()
    {
    }

    public function execute(): string
    {
        return $this->renderContent($this->renderForm());
    }

    private function renderContent(string $content): string
    {
        return "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <title>ユーザ登録</title>
                </head>
                <body>
                    <h1>ユーザ登録</h1>
                    {$content}
                </body></html>";
    }

    private function renderForm(): string
    {
        return "<form enctype='multipart/form-data' action='/api/users' method='POST'>
                    <label for='user_name'>ユーザ名</label>
                    <input type='text' id='user_name' name='user_name' required>
                    <label for='mail'>メールアドレス</label>
                    <input type='email' id='mail' name='mail' required>
                    <label for='password'>パスワード</label>
                    <input type='password' id='password' name='password' required>
                    <label for='profile_url'>プロフィール画像URL</label>
                    <input type='url' id='profile_url' name='profile_url'>
                    <button type='submit'>登録</button>
                </form>";
    }
}
