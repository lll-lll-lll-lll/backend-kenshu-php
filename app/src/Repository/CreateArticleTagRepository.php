<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

/**
 * Class CreateArticleTagRepository
 * 記事のタグを複数紐付けるリポジトリ
 */
class CreateArticleTagRepository
{
    /**
     * @param PDO $pdo
     * @param int $article_id
     * @param array<int> $tags
     */
    public function execute(PDO $pdo, int $article_id, array $tags): void
    {
        $sql = '
            INSERT INTO "article_tag" (article_id, tag_id)
            VALUES (:article_id, :tag_id)';

        $stmt = $pdo->prepare($sql);

        foreach ($tags as $tagId) {
            $stmt->execute([
                ':article_id' => $article_id,
                ':tag_id' => $tagId,
            ]);
        }
    }
}
