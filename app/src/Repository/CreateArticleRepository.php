<?php
declare(strict_types=1);

namespace App\Repository;

use Exception;
use PDO;

class CreateArticleRepository
{
    public function __construct()
    {
    }

    public function execute(PDO $pdo, string $title, string $contents, int $user_id): int
    {
        try {
            $sql = 'INSERT INTO "article" (title, contents, user_id) VALUES (:title, :contents, :user_id)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':contents' => $contents,
                ':user_id' => $user_id
            ]);
            $articleId = $pdo->lastInsertId();
            return (int)$articleId;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
