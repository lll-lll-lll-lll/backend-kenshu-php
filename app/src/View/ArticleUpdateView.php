<?php
declare(strict_types=1);

namespace App\View;

use App\Handler\Article\GetUpdateArticleViewHandler;
use Exception;

/**
 * 記事更新ページ
 */
class ArticleUpdateView
{
    private GetUpdateArticleViewHandler $getUpdateArticleViewHandler;
    private TagListView $tagListView;

    public function __construct(TagListView $tagListView, GetUpdateArticleViewHandler $getUpdateArticleViewHandler)
    {
        $this->tagListView = $tagListView;
        $this->getUpdateArticleViewHandler = $getUpdateArticleViewHandler;
    }

    public function execute(int $articleId): string
    {
        try {
            $this->getUpdateArticleViewHandler->execute($articleId);
            $tagsHTML = $this->tagListView->execute();
        } catch (Exception) {
            return self::renderNotAuthority();
        }
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
                <input type="hidden" name="article_id" value="{$articleId}">
                <div>
                    <label for="title">タイトル</label>
                    <input type="text" id="title" name="title" value="{$title}">
                </div>
                <div>
                    <label for="content">本文</label>
                    <textarea id="content" name="content">{$content}</textarea>
                </div>
                <div>
                    <label for='tags'>タグを選択してください</label><br>
                    <select id='tags' name='tags[]' multiple>
                        {$tagsHTML}
                    </select><br>
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
