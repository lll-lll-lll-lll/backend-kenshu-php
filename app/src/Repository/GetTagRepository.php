<?php
declare(strict_types=1);

namespace App\Repository;

use Exception;
use PDO;

/**
 * tagテーブルのIDを取得する
 */
class GetTagRepository
{
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function execute(PDO $pdo, int $tag_id): int
    {
        $sql = '
            SELECT id FROM "tag" WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $tag_id]);
        $result = $stmt->fetchColumn();
        if ($result === false) {
            throw new Exception('Failed to get tag');
        }
        return $result;
    }
}
