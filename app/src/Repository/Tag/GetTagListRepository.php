<?php
declare(strict_types=1);

namespace App\Repository\Tag;

use App\Model\Tag;
use Exception;
use PDO;

class GetTagListRepository
{
    /**
     * @return array<Tag>
     * @throws Exception
     */
    public function execute(PDO $pdo): array
    {
        $stmt = $pdo->prepare('
        SELECT 
            id, 
            name
        FROM 
            tag');
        if ($stmt->execute() === false) {
            throw new Exception('データ取得に失敗しました');
        }

        $tags = [];
        while ($tag = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tags[] = new Tag($tag['id'], $tag['name']);
        }
        return $tags;
    }
}
