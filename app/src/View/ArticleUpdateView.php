<?php
declare(strict_types=1);

namespace App\View;

class ArticleUpdateView
{
    public function __construct()
    {
    }

    public static function execute(int $article_id): string
    {
        $title = htmlspecialchars($_POST['title'] ?? '');
        $content = htmlspecialchars($_POST['content'] ?? '');
        return <<< EOT
        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>記事更新</title>
        </head>
        <body>
            <h1>記事更新</h1>
            <form action="/api/article/update" method="post">
                <input type="hidden" name="article_id" value="{$article_id}">
                <div>
                    <label for="title">タイトル</label>
                    <input type="text" id="title" name="title" value="{$title}">
                </div>
                <div>
                    <label for="content">本文</label>
                    <textarea id="content" name="content">{$content}</textarea>
                </div>
                <button type="submit">更新</button>
            </form>
        </body>
        </html>
        EOT;
    }

    public static function renderNotAuthority(): string
    {
        return "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'><title></title>
                    <meta http-equiv='refresh' content='3;url=/'>
                </head>
                <body>
                    <p>あなたには権限がありません。３秒後にリダイレクトします。</p>
                </body>
                </html>
            ";
    }
}
