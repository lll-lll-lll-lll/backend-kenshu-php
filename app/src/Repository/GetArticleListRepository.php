<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Article;
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
            id, 
            title, 
            contents, 
            created_at, 
            user_id
        FROM 
            article
        ORDER BY 
            created_at DESC 
        LIMIT 10
    ');
        $stmt->execute();
        $articles = [];
        while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = new Article($article['id'], $article['title'], $article['contents'], $article['created_at'], $article['user_id']);
        }
        return $articles;
    }
}
