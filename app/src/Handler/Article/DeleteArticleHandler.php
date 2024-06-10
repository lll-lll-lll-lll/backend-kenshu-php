<?php
declare(strict_types=1);

namespace App\Handler\Article;

use App\Request\DeleteArticleRequest;
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
        try {
            $req = new DeleteArticleRequest($_POST, $_SESSION);
            $this->deleteArticleUseCase->execute($req->articleId, $req->userId);
        } catch (Exception) {
            echo $this->renderNoDeleteArticleAuthority();
        }
    }

    private function renderNoDeleteArticleAuthority(): string
    {
        return '削除権限がありません';
    }
}
