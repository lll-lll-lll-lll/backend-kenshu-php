<?php
declare(strict_types=1);

namespace App\UseCase\Article;

use App\Repository\Article\DeleteArticleRepository;
use App\Repository\Article\GetArticleByUseId;
use Exception;
use PDO;

class DeleteArticleUseCase
{
    private PDO $pdo;
    private DeleteArticleRepository $deleteArticleRepository;
    private GetArticleByUseId $getArticleByUserIdRepository;

    public function __construct(PDO $pdo, GetArticleByUseId $getArticleByUserIdRepository, DeleteArticleRepository $articleRepository)
    {
        $this->pdo = $pdo;
        $this->getArticleByUserIdRepository = $getArticleByUserIdRepository;
        $this->deleteArticleRepository = $articleRepository;
    }

    public function execute(int $articleId, int $sessionUserId): void
    {
        try {
            $this->pdo->beginTransaction();
            $article = $this->getArticleByUserIdRepository->execute($this->pdo, $articleId, $sessionUserId);
            $this->deleteArticleRepository->execute($this->pdo, $article->id);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
