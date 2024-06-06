<?php
declare(strict_types=1);

namespace App\UseCase\Article;

use App\Model\Article;
use App\Repository\Article\GetArticleListRepository;
use PDO;

class GetArticleListUseCase
{
    public GetArticleListRepository $getArticleListRepository;
    private PDO $pdo;

    public function __construct(PDO $pdo, GetArticleListRepository $getArticleListRepository)
    {
        $this->pdo = $pdo;
        $this->getArticleListRepository = $getArticleListRepository;
    }

    /**
     * @return Article[]
     */
    public function execute(): array
    {
        return $this->getArticleListRepository->execute($this->pdo);
    }
}
