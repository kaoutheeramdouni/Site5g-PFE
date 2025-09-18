<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: tickets.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

header("Location: tickets.php");
exit();
?>
