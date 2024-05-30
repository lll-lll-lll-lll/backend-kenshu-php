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
            $lastInsertedID = $this->createRepository->execute($this->pdo,
                $req->title, $req->contents, $req->user_id,
                $req->thumbnail_image_url, $req->tag_name);
            if ($lastInsertedID === 0) {
                throw new Exception('Failed to create article');
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
