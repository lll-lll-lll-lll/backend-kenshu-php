<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

class Database {
    private static Database $instance;
    private PDO $connection;

    private function __construct(array $config) {
        $this->connection = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getConnection(array $config): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance->connection;
    }
}

