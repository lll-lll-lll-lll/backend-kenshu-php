<?php
declare(strict_types=1);

namespace App\Handler;

use App\Model\Article;
use App\UseCase\GetArticleListUseCase;
use DateTime;
use Exception;

class GetArticleListHandler
{
    public GetArticleListUseCase $getArticleListUseCase;

    public function __construct(GetArticleListUseCase $getArticleListUseCase)
    {
        $this->getArticleListUseCase = $getArticleListUseCase;
    }

    public function render(): string
    {
        $articles = $this->getArticleListUseCase->execute();
        $articlesHTML = $this->renderForm();
        foreach ($articles as $article) {
            $articlesHTML .= $this->renderArticle($article);
        }
        return $this->renderContent($articlesHTML);
    }

    // TODO タグを複数選択できるようにする
    private function renderForm(): string
    {
        return "<form enctype='multipart/form-data' action='/articles' method='POST'>
            <input type='hidden' name='MAX_FILE_SIZE' value='30000' required/>
            
            <label for='title'>タイトルを入力してください:</label><br>
            <input type='text' id='title' name='title' required><br>
            
            <label for='contents'>コンテンツを入力してください:</label><br>
            <textarea id='contents' name='contents' rows='4' cols='50' required></textarea><br>
            
            <label for='image_url'>サムネイル画像のURLを入力してください</label><br>
            <input type='text' name='thumbnail_image_url' id='thumbnail_image_url'><br>
            
           <label for='tags'>タグを選択してください</label><br>
            <select id='tags' name='tags[]' multiple>
                <option value='1'>タグ1</option>
                <option value='key1'>タグ2</option>
                <option value='key2'>タグ3</option>
                <option value='key3'>タグ4</option>
            </select><br>
            <input type='submit' value='送信'>
        </form>";
    }

    private function renderArticle(Article $article): string
    {
        $title = htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8');
        $contents = htmlspecialchars($article->contents, ENT_QUOTES, 'UTF-8');

        try {
            $date = new DateTime($article->created_at);
            $formattedDate = htmlspecialchars($date->format('Y年m月d日 H:i:s'), ENT_QUOTES, 'UTF-8');
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
            return '';
        }
        $articleLinkHref = 'articles/' . $article->id;
        return "<a href={$articleLinkHref}>" . $title . "</a>" .
            '<p>' . $contents . '</p>' .
            '<p>' . $formattedDate . '</p>';
    }

    private function renderContent(string $content): string
    {
        return "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <title>記事一覧</title>
                </head>
                <body>
                    <h1>記事一覧</h1>
                    {$content}
                </body></html>";
    }
}
