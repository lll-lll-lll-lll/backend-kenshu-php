<?php
declare(strict_types=1);

namespace App\View;

class LoginView
{

    public function __construct()
    {
    }

    public static function FailedLogin(): string
    {
        return '<p>メールアドレスもしくはパスワードが間違えています。</p>';
    }

    public static function renderNotLogin(): string
    {
        return "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'><title></title>
                    <meta http-equiv='refresh' content='3;url=/login'>
                </head>
                <body>
                    <p>ログインをしてください。３秒後にリダイレクトします。</p>
                </body>
                </html>
            ";
    }

    public function execute(): string
    {
        return $this->loginForm();
    }

    private function loginForm(): string
    {
        return "<form  enctype='multipart/form-data' action='/api/login' method='POST'>
            <label for='mail'>mail</label>
            <input type='text' name='mail' id='mail'>
            <label for='password'>password</label>
            <input type='password' name='password' id='password'>
            <input type='submit' value='login'>
        </form> ";
    }
}
