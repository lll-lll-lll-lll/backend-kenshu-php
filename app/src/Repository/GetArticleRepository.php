<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Article;
use Exception;
use PDO;

class GetArticleRepository
{
    /**
     * @throws Exception
     */
    public function execute(PDO $pdo, int $id): Article
    {
        try {
            $stmt = $pdo->prepare('SELECT id, title, contents, created_at, user_id FROM article WHERE id = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception("Article with ID $id not found.");
            }
            return new Article($result['id'], $result['title'], $result['contents'], $result['created_at'], $result['user_id']);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
