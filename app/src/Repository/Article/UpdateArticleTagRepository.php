<?php
declare(strict_types=1);

namespace App\Repository\Article;

use PDO;

class UpdateArticleTagRepository
{
    public function __construct()
    {
    }

    /**
     * 記事タグを一旦削除してから新しいタグをインサートする
     */
    public function execute(PDO $pdo, int $articleId, array $tagIds): void
    {
        $stmt = $pdo->prepare('DELETE FROM article_tag WHERE article_id = :article_id');
        $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $pdo->prepare('INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)');
        foreach ($tagIds as $tagId) {
            $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
            $stmt->bindValue(':tag_id', $tagId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}
