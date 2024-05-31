<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class CreateArticleRepository
{
    public function __construct()
    {
    }

    public function executeInsertArticleTag(PDO $pdo, int $article_id, int $tag_id): void
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

    public function executeInsertTag(PDO $pdo, string $tag_name): int
    {
        $sql = '
            INSERT INTO "tag" (name) 
            VALUES (:tag_name)
            RETURNING id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tag_name' => $tag_name]);
        return $stmt->fetchColumn();
    }

    public function executeInsertArticle(PDO $pdo, string $title, string $contents, int $user_id): int
    {
        $sql = '
                INSERT INTO "article" (title, contents, user_id) 
                VALUES (:title, :contents, :user_id)
                RETURNING id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':contents' => $contents,
            ':user_id' => $user_id,
        ]);
        return $stmt->fetchColumn();
    }

    public function executeInsertArticleImage(PDO $pdo, string $thumbnail_image_url, int $article_id): void
    {
        $sql = '
            INSERT INTO "article_image" (url, article_id)
            VALUES (:url, :article_id)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':url' => $thumbnail_image_url,
            ':article_id' => $article_id,
        ]);
    }
}
