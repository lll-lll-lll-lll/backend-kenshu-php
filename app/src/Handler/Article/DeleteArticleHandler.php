<?php
declare(strict_types=1);

namespace App\Handler\Article;

use App\UseCase\Article\DeleteArticleUseCase;
use Exception;

class DeleteArticleHandler
{
    private DeleteArticleUseCase $deleteArticleUseCase;

    public function __construct(DeleteArticleUseCase $deleteArticleUseCase)
    {
        $this->deleteArticleUseCase = $deleteArticleUseCase;
    }

    public function execute(): void
    {
        $articleId = $_POST['article_id'];
        try {
            if ($articleId <= 0) {
                throw new Exception('記事が存在しません');
            }
            $this->deleteArticleUseCase->execute((int)$articleId);
        } catch (Exception) {
            http_response_code(500);
            echo $this->renderNoDeleteArticleAuthority();
        }
    }

    private function renderNoDeleteArticleAuthority(): string
    {
        return '削除権限がありません';
    }
}
