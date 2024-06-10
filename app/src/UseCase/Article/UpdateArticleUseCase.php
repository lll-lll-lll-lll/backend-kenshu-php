<?php
declare(strict_types=1);

namespace App\UseCase\Article;

use App\Repository\Article\GetArticleRepository;
use App\Repository\Article\UpdateArticleRepository;
use App\Request\UpdateArticleRequest;
use Exception;
use PDO;

class UpdateArticleUseCase
{
    private PDO $pdo;
    private GetArticleRepository $getArticleRepository;

    private UpdateArticleRepository $updateArticleRepository;


    public function __construct(PDO $pdo, GetArticleRepository $getArticleRepository, UpdateArticleRepository $updateArticleRepository)
    {
        $this->pdo = $pdo;
        $this->getArticleRepository = $getArticleRepository;
        $this->updateArticleRepository = $updateArticleRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(UpdateArticleRequest $req): void
    {
        try {
            $this->pdo->beginTransaction();
            $article = $this->getArticleRepository->execute($this->pdo, $req->articleId);
            $this->updateArticleRepository->execute($this->pdo, $article->id, $req->title, $req->content);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
