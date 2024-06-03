<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class CreateArticleImageRepository
{
    public function execute(PDO $pdo, string $thumbnail_image_url, int $article_id): void
    {
        $sql = '
            INSERT INTO "article_image" (url, article_id)
            VALUES (:url, :article_id)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':url' => $thumbnail_image_url,
            ':article_id' => $article_id,
        ]);
    }
}
