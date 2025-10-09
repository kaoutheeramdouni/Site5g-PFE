<?php
$host    = getenv('DB_HOST') ?: 'mysql-service';
$db      = getenv('DB_NAME') ?: 'site5gdb';
$user    = getenv('DB_USER') ?: 'site5guser';
$pass    = getenv('DB_PASSWORD') ?: 'Site5gPass123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;ssl-mode=DISABLED";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    error_log("Erreur DB: " . $e->getMessage());
    exit("Erreur interne, réessayez plus tard.");
}
