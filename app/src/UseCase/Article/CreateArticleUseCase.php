<?php
declare(strict_types=1);

namespace App\UseCase\Article;

use App\Repository\Article\CreateArticleImageRepository;
use App\Repository\Article\CreateArticleRepository;
use App\Repository\Article\CreateArticleTagRepository;
use App\Request\CreateArticleRequest;
use Exception;
use PDO;

class CreateArticleUseCase
{
    private PDO $pdo;
    private CreateArticleRepository $createArticleRepository;
    private CreateArticleTagRepository $createArticleTagRepository;
    private CreateArticleImageRepository $createArticleImageRepository;

    public function __construct(
        PDO $pdo,
        CreateArticleRepository $createRepository,
        CreateArticleTagRepository $createArticleTagRepository,
        CreateArticleImageRepository $createArticleImageRepository)
    {
        $this->pdo = $pdo;
        $this->createArticleRepository = $createRepository;
        $this->createArticleTagRepository = $createArticleTagRepository;
        $this->createArticleImageRepository = $createArticleImageRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(CreateArticleRequest $req): void
    {
        try {
            $this->pdo->beginTransaction();
            try {
                $articleId = $this->createArticleRepository->execute($this->pdo, $req->title, $req->contents, $req->userId);
                $this->createArticleImageRepository->execute($this->pdo, $req->thumbnailImageUrl, $articleId);
                $this->createArticleTagRepository->execute($this->pdo, $articleId, $req->tagIds);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
