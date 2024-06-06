<?php
declare(strict_types=1);

namespace App\UseCase\Article;

use App\Repository\Article\DeleteArticleRepository;
use App\Repository\Article\GetArticleRepository;
use Exception;
use PDO;

class DeleteArticleUseCase
{
    private PDO $pdo;
    private DeleteArticleRepository $deleteArticleRepository;
    private GetArticleRepository $getArticleRepository;

    public function __construct(PDO $pdo, GetArticleRepository $getArticleRepository, DeleteArticleRepository $articleRepository)
    {
        $this->pdo = $pdo;
        $this->getArticleRepository = $getArticleRepository;
        $this->deleteArticleRepository = $articleRepository;
    }

    public function execute(int $articleId, int $sessionUserId): void
    {
        try {
            $this->pdo->beginTransaction();
            $article = $this->getArticleRepository->execute($this->pdo, $articleId);
            if ($article->user_id !== $sessionUserId) {
                throw new Exception('削除権限がありません');
            }
            $this->deleteArticleRepository->execute($this->pdo, $article->id);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
