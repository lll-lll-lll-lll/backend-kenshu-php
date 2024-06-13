<?php
declare(strict_types=1);

namespace App\Repository\Article;

use App\Model\Article;
use PDO;

class GetArticleListRepository
{
    public function __construct()
    {
    }

    /**
     * @return Article[]
     */
    public function execute(PDO $pdo): array
    {
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
        ORDER BY 
            a.created_at DESC 
        LIMIT 10;
    ');

        $stmt->execute();
        /**
         * @var Article[] $articles
         */
        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles = Article::mapping($row);
        }
        return $articles;
    }
}
