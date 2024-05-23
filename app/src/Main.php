<?php
declare(strict_types=1);

namespace App;

use App\Handler\ArticleHandler;
use PDO;
use PDOException;

class Main
{
    public function  run():void
    {
        try {
            $article_handler = new ArticleHandler();
            $dsn = 'pgsql:host=postgresql;dbname=db;user=root;password=password';
            $db = new PDO($dsn);

            $sql = 'SELECT version();';
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
            echo 'Connection to PostgreSQL database successful!';
        } catch (PDOException $e) {
            echo $e->getMessage();
            // 500を返すのもあり。投げっぱなしでもOK
        }

    }
}
