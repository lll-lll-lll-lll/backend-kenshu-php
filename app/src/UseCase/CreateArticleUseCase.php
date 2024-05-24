<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Repository\CreateArticleRepository;
use Exception;
use PDO;
use PDOException;

class CreateArticleUseCase implements ICreateArticleUseCase
{
    private PDO $pdo;
    private CreateArticleRepository $createRepository;
    public function __construct(PDO $pdo, CreateArticleRepository $createRepository)
    {
        $this->pdo = $pdo;
        $this->createRepository = $createRepository;
    }

    public function execute(string $title, string $contents, int $user_id): int
    {
        try {
            $this->pdo->beginTransaction();
            $lastInsertedID = $this->createRepository->execute($this->pdo, $title, $contents, $user_id);
            $this->pdo->commit();
            return $lastInsertedID;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage());
        }
    }
}
