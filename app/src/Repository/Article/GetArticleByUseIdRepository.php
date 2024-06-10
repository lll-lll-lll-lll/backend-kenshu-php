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
            $stmt = $pdo->prepare('SELECT id, title, contents, created_at, user_id FROM article WHERE id = :id AND user_id = :user_id');
            $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception("Article with ID $articleId not found.");
            }
            return new Article($result['id'], $result['title'], $result['contents'], $result['created_at'], $result['user_id']);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
