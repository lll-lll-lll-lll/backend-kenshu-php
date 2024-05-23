<?php
declare(strict_types=1);

namespace App\Repository\Article;
use App\Model\Article;
use ErrorException;
use Exception;
use PDO;
use PDOException;

class CreateRepository implements ICreateRepository
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function execute(string $title, string $contents, int $user_id): int
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO "article" (title, contents, user_id) VALUES (:title, :contents, :user_id)';
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                ':title' => $title,
                ':contents' => $contents,
                ':user_id' => $user_id
            ]);
            $articleId = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return (int)$articleId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage());
        }
    }
}
