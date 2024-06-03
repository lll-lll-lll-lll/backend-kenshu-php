<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class CreateArticleTagRepository
{
    public function execute(PDO $pdo, int $article_id, int $tag_id): void
    {
        $sql = '
            INSERT INTO "article_tag" (article_id, tag_id)
            VALUES (:article_id, :tag_id)
        ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':article_id' => $article_id,
            ':tag_id' => $tag_id,
        ]);
    }
}
