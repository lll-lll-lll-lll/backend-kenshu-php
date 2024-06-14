<?php
declare(strict_types=1);

namespace App\Repository\Article;

use App\Model\Article;
use Exception;
use PDO;

class GetArticleByUseIdRepository
{
    public function __construct()
    {
    }

    public function execute(PDO $pdo, int $articleId, int $userId): Article
    {
        try {
            $stmt = $pdo->prepare('
            SELECT
                article.id AS article_id,
                article.title,
                article.contents,
                article.created_at AS article_created_at,
                "user".id AS user_id,
                "user".name AS user_name,
                "user".mail AS user_mail,
                "user".profile_url AS user_profile_url,
                array_agg(article_image.thumbnail_image_path) AS thumbnail_image_paths,
                array_agg(article_image.sub_image_path) AS sub_image_paths,
                array_agg(tag.id) AS tag_ids,
                array_agg(tag.name) AS tag_names
            FROM
                article 
            JOIN
                "user"  ON article.user_id = "user".id
            LEFT JOIN
                article_image ON article.id = article_image.article_id
            LEFT JOIN
                article_tag ON article.id = article_tag.article_id
            LEFT JOIN
                tag  ON article_tag.tag_id = tag.id
            WHERE article.id = :id AND "user".id = :user_id
            GROUP BY
                article.id, "user".id;');
            $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception("Article with ID $articleId not found.");
            }
            return Article::mapping($result);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
