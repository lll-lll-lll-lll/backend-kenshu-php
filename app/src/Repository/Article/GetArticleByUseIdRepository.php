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
                    a.id AS article_id,
                    a.title,
                    a.contents,
                    a.created_at AS article_created_at,
                    u.id AS user_id,
                    u.name AS user_name,
                    u.mail AS user_mail,
                    u.profile_url AS user_profile_url,
                    ai.thumbnail_image_path,
                    ai.sub_image_path,
                    t.id AS tag_id,
                    t.name AS tag_name
                FROM 
                    article a
                JOIN 
                    "user" u ON a.user_id = u.id
                LEFT JOIN 
                    article_image ai ON a.id = ai.article_id
                LEFT JOIN 
                    article_tag at ON a.id = at.article_id
                LEFT JOIN 
                    tag t ON at.tag_id = t.id
                WHERE a.id = :id AND u.id = :user_id;');
            $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception("Article with ID $articleId not found.");
            }
            $articleId = $result['article_id'];
            return Article::mapping($result)[$articleId];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
