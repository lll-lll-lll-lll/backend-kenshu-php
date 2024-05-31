<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Repository\CreateArticleRepository;
use App\Request\CreateArticleRequest;
use Exception;
use PDO;

class CreateArticleUseCase
{
    private PDO $pdo;
    private CreateArticleRepository $createRepository;

    public function __construct(PDO $pdo, CreateArticleRepository $createRepository)
    {
        $this->pdo = $pdo;
        $this->createRepository = $createRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(CreateArticleRequest $req): void
    {
        try {
            $this->pdo->beginTransaction();
            try {
                $articleId = $this->createRepository->executeInsertArticle($this->pdo, $req->title, $req->contents, $req->user_id);
                $this->createRepository->executeInsertArticleImage($this->pdo, $req->thumbnail_image_url, $articleId);
                $tagId = $this->createRepository->executeInsertTag($this->pdo, $req->tag_name);
                $this->createRepository->executeInsertArticleTag($this->pdo, $articleId, $tagId);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
