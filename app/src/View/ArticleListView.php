<?php
declare(strict_types=1);

namespace App\View;

use App\Handler\Article\GetArticleListHandler;
use App\Handler\Tag\GetTagListHandler;
use App\Model\Article;
use App\Model\Tag;
use DateTime;
use Exception;

class ArticleListView
{
    private GetArticleListHandler $articleListHandler;
    private GetTagListHandler $tagListHandler;

    public function __construct(GetArticleListHandler $articleListHandler, GetTagListHandler $tagListHandler)
    {
        $this->articleListHandler = $articleListHandler;
        $this->tagListHandler = $tagListHandler;
    }

    public function render(): string
    {
        try {
            $articles = $this->articleListHandler->execute();
            $tags = $this->tagListHandler->execute();
            $tagsHTML = $this->renderTags($tags);
            $articlesHTML = $this->renderForm($tagsHTML);
            foreach ($articles as $article) {
                $articlesHTML .= $this->renderArticle($article);
            }
            return $this->renderContent($articlesHTML);
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
            header('Location: /');
            return '';
        }
    }

    /**
     * @param array<Tag> $tags
     */
    private function renderTags(array $tags): string
    {
        $tagsHTML = '';
        foreach ($tags as $tag) {
            $tagName = htmlspecialchars($tag->name, ENT_QUOTES, 'UTF-8');
            $tagsHTML .= "<option value='{$tag->id}'>{$tagName}</option>";
        }
        return $tagsHTML;
    }

    private function renderForm(string $tagsHTML): string
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
                {$tagsHTML}
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
            '<p>' . $formattedDate . '</p>'
            . $this->renderDeleteArticleButton($article->id)
            . $this->renderUpdateArticleButton($article->id) . '<br>';
    }

    private function renderDeleteArticleButton(int $articleId): string
    {
        return "<form enctype='multipart/form-data' action='/api/articles/delete' method='POST'>
            <input type='hidden' name='article_id' value='{$articleId}' required/>
            <input type='submit' value='削除'>
        </form>";
    }

    private function renderUpdateArticleButton(int $articleId): string
    {
        return "<a href='/article/update/{$articleId}'>更新する</a>";
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
