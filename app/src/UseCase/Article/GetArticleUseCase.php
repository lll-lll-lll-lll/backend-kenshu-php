<?php
declare(strict_types=1);

namespace App\UseCase\Article;

use App\Model\Article;
use App\Repository\Article\GetArticleRepository;
use Exception;
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

    /**
     * @throws Exception
     */
    public function execute(int $articleId): Article
    {
        try {
            return $this->getArticleRepository->execute($this->pdo, $articleId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
