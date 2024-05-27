<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class GetArticleListRepository
{
    public function __construct()
    {
    }

    public function execute(PDO $pdo): array
    {
        $stmt = $pdo->prepare('
        SELECT 
            a.id AS article_id, 
            a.title, 
            a.contents, 
            a.created_at, 
            a.user_id, 
            ai.id AS image_id, 
            ai.url
        FROM 
            article a 
        LEFT JOIN 
            article_image ai 
        ON 
            a.id = ai.article_id 
        ORDER BY 
            a.created_at DESC 
        LIMIT 10
    ');
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result) {
            return [];
        }
        return $result;
    }
}
