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

    public function execute(PDO $pdo, string $title, string $contents, int $user_id, string $thumbnail_image_url, string $tag_name): int
    {
        try {
            $articleId = $this->executeArticle($pdo, $title, $contents, $user_id);
            $this->executeArticleImage($pdo, $thumbnail_image_url, $articleId);
            $tagId = $this->executeTag($pdo, $tag_name);
            $this->executeArticleTag($pdo, $articleId, $tagId);
            return $articleId;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function executeArticle(PDO $pdo, string $title, string $contents, int $user_id): int
    {
        $sql = '
                INSERT INTO "article" (title, contents, user_id) 
                VALUES (:title, :contents, :user_id)
                RETURNING id
            ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':contents' => $contents,
            ':user_id' => $user_id,
        ]);
        return $stmt->fetchColumn();
    }

    private function executeArticleImage(PDO $pdo, string $thumbnail_image_url, int $article_id): void
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

    private function executeTag(PDO $pdo, string $tag_name): int
    {
        $sql = '
            INSERT INTO "tag" (name) 
            VALUES (:tag_name)
            RETURNING id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tag_name' => $tag_name]);
        return $stmt->fetchColumn();
    }

    public function executeArticleTag(PDO $pdo, int $article_id, int $tag_id): void
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
