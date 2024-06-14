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
            GROUP BY
                article.id, "user".id
            ORDER BY
                article.created_at DESC
            LIMIT 10;');
        $stmt->execute();
        /**
         * @var Article[] $articles
         */
        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = Article::mapping($row);
        }
        return $articles;
    }
}
