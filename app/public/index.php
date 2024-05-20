<?php
require __DIR__.'/../vendor/autoload.php';

try {
    $dsn = 'pgsql:host=postgresql;dbname=db;user=root;password=password';
    $db = new PDO($dsn);

    $sql = 'SELECT version();';
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);
    echo 'Connection to PostgreSQL database successful!';
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}