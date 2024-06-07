<?php
declare(strict_types=1);

namespace App\Repository\Article;

use PDO;

class UpdateArticleRepository
{
    public function __construct()
    {
    }

    public function execute(PDO $pdo, int $articleId, string $title, string $content): void
    {
        $stmt = $pdo->prepare('UPDATE article SET title = :title, contents = :contents WHERE id = :id');
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':contents', $content, PDO::PARAM_STR);
        $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
