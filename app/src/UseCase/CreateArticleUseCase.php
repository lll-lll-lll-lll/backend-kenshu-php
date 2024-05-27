<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Repository\CreateArticleRepository;
use App\Request\CreateArticleRequest;
use App\Request\CreateUserRequest;
use Exception;
use PDO;
use PDOException;

class CreateArticleUseCase
{
    private PDO $pdo;
    private CreateArticleRepository $createRepository;

    public function __construct(PDO $pdo, CreateArticleRepository $createRepository)
    {
        $this->pdo = $pdo;
        $this->createRepository = $createRepository;
    }

    public function execute(CreateArticleRequest $req): int
    {
        try {
            $this->pdo->beginTransaction();
            $lastInsertedID = $this->createRepository->execute($this->pdo, $req->title, $req->contents, $req->user_id);
            $this->pdo->commit();
            return $lastInsertedID;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage());
        }
    }
}
