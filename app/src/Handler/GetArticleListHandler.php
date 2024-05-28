<?php
declare(strict_types=1);

namespace App\Handler;

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
        $result = $this->getArticleListUseCase->execute();
        $html = $this->renderHeader();
        $html .= '<h1>記事一覧</h1>';
        foreach ($result as $article) {
            $html .= $this->renderArticle($article);
        }
        $html .= $this->renderFooter();
        return $html;
    }

    private function renderHeader(): string
    {
        return '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>記事一覧</title>
                </head>
                <body>';
    }

    private function renderArticle($article): string
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

        return '<h2>' . $title . '</h2>' .
            '<p>' . $contents . '</p>' .
            '<p>' . $formattedDate . '</p>';
    }

    private function renderFooter(): string
    {
        return '</body></html>';
    }
}
