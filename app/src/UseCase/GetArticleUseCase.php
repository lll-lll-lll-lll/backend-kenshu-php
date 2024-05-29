<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Model\Article;
use App\Repository\GetArticleRepository;
use PDO;

class GetArticleUseCase
{
    private GetArticleRepository $getArticleRepository;
    private PDO $pdo;

    public function __construct(PDO $pdo, GetArticleRepository $getArticleRepository)
    {
        $this->pdo = $pdo;
        $this->getArticleRepository = $getArticleRepository;
    }

    public function execute(int $articleId): Article
    {
        return $this->getArticleRepository->execute($this->pdo, $articleId);
    }
}
