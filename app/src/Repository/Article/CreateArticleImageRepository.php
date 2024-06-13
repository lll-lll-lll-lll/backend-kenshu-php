<?php
declare(strict_types=1);

namespace App\Repository\Article;

use PDO;

class CreateArticleImageRepository
{
    public function execute(PDO $pdo, string $thumbnail_image_url, string $sub_image_path, int $article_id): void
    {
        $sql = '
            INSERT INTO "article_image" (thumbnail_image_path, sub_image_path, article_id)
            VALUES (:thumbnail_image_path, :sub_image_path,  :article_id)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':thumbnail_image_path' => $thumbnail_image_url,
            ':sub_image_path' => $sub_image_path,
            ':article_id' => $article_id,
        ]);
    }
}
