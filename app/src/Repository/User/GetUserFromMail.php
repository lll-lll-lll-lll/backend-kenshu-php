<?php
declare(strict_types=1);

namespace App\Repository\User;

use App\Model\User;
use InvalidArgumentException;
use PDO;

class GetUserFromMail
{
    public function __construct()
    {
    }

    public function execute(PDO $pdo, string $mail): User
    {
        $stmt = $pdo->prepare('SELECT id, name, mail, password, profile_url  FROM "user" WHERE mail = :mail');
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            throw new InvalidArgumentException('user is not found');
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User(id: $result['id'], name: $result['name'], mail: $result['mail'], password: $result['password'], profileUrl: $result['profile_url']);
    }
}
