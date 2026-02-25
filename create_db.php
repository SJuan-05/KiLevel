<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS kilevel5;');
    echo 'Database kilevel5 created successfully';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
