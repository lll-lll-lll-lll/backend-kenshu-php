<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class CreateArticleTagRepository
{
    /**
     * @param PDO $pdo
     * @param int $article_id
     * @param array<int> $tags
     */
    public function execute(PDO $pdo, int $article_id, array $tags): void
    {
        $sql = 'INSERT INTO "article_tag" (article_id, tag_id) VALUES ';
        $values = [];
        $params = [];

        foreach ($tags as $index => $tag_id) {
            $values[] = "(:article_id_$index, :tag_id_$index)";
            $params[":article_id_$index"] = $article_id;
            $params[":tag_id_$index"] = $tag_id;
        }

        $sql .= implode(", ", $values);
        echo $sql;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
}
