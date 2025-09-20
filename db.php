<?php
// db.php
$host    = 'db';               // nom du conteneur MySQL
$db      = 'site5g';           // base définie dans docker-compose.yml
$user    = 'site5guser';
$pass    = 'Site5gPass123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
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
