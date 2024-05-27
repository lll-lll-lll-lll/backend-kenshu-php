<?php
declare(strict_types=1);

namespace App\Handler;

use App\UseCase\GetArticleListUseCase;
use DateTime;

class GetArticleListHandler
{
    public GetArticleListUseCase $getArticleListUseCase;

    public function __construct(GetArticleListUseCase $getArticleListUseCase)
    {
        $this->getArticleListUseCase = $getArticleListUseCase;
    }

    public function render(): string
    {
        $result = $this->execute();
        $html = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>記事一覧</title>
                    </head>
                    <body>';

        foreach ($result as $article) {
            $title = htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');
            $contents = htmlspecialchars($article['contents'], ENT_QUOTES, 'UTF-8');
            $date = new DateTime($article['created_at']);
            $formattedDate = htmlspecialchars($date->format('Y年m月d日 H:i:s'), ENT_QUOTES, 'UTF-8');
            $url = !empty($article['url']) ? '<p><a href="' . htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8') . '</a></p>' : '';

            $html .= '<h2>' . $title . '</h2>';
            $html .= '<p>' . $contents . '</p>';
            $html .= '<p>' . $formattedDate . '</p>';
            $html .= $url;
        }
        $html .= '</body></html>';
        return $html;
    }

    private function execute(): array
    {
        return $this->getArticleListUseCase->execute();
    }
}
