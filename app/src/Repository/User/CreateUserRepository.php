<?php
declare(strict_types=1);

namespace App\Repository\User;

use Exception;
use PDO;
use PDOException;

class CreateUserRepository
{
    public function execute(PDO $pdo, string $user_name, string $mail, string $password_hash, string $profile_url): void
    {
        try {
            $sql = 'INSERT INTO "user" (name, mail, password, profile_url) VALUES (:name, :mail, :password,:profile_url)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $user_name,
                ':mail' => $mail,
                ':password' => $password_hash,
                ':profile_url' => $profile_url
            ]);
        } catch (Exception $e) {
            throw new PDOException($e->getMessage());
        }
    }
}
