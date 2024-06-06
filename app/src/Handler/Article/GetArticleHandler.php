<?php
declare(strict_types=1);

namespace App\Handler\Article;

use App\Model\Article;
use App\UseCase\Article\GetArticleUseCase;
use Exception;

class GetArticleHandler
{
    private GetArticleUseCase $getArticleUseCase;

    public function __construct(GetArticleUseCase $getArticleUseCase)
    {
        $this->getArticleUseCase = $getArticleUseCase;
    }

    public function execute(int $articleId): string
    {
        if ($articleId <= 0) {
            return $this->renderNotFoundArticle();
        }
        try {
            $article = $this->getArticleUseCase->execute($articleId);
        } catch (Exception) {
            return $this->renderNotFoundArticle();
        }
        return $this->renderArticle($article);
    }

    private function renderNotFoundArticle(): string
    {
        return "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <title>記事詳細</title>
                    </head>
                    <body>
                        <h1>記事が見つかりません</h1>
                    </body>
                    </html>";
    }

    private function renderArticle(Article $article): string
    {
        return "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <title>記事詳細</title>
                </head>
                <body>
                    <h1>記事詳細</h1>
                    <h2>{$article->title}</h2>
                    <p>{$article->contents}</p>
                    <p>{$article->created_at}</p>
                </body>
                </html>";
    }
}
