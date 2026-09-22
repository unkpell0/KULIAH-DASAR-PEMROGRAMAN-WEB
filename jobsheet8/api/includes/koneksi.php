<?php
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'sifilm';
$user = getenv('DB_USER') ?: 'postgres';
$pass = getenv('DB_PASS') ?: '1234';
$ssl  = getenv('DB_SSLMODE') ?: 'prefer';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=$ssl", $user, $pass);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}