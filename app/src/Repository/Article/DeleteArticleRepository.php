<?php
declare(strict_types=1);

namespace App\Repository\Article;

use PDO;

class DeleteArticleRepository
{
    public function __construct()
    {
    }

    public function execute(PDO $pdo, int $articleId): void
    {
        $sql = 'DELETE FROM article WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
