<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: mes_tickets.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$ticket = $stmt->fetch();

if (!$ticket) {
    header("Location: tickets.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];

    $update = $pdo->prepare("UPDATE tickets SET titre = ?, description = ? WHERE id = ? AND user_id = ?");
    $update->execute([$titre, $description, $id, $_SESSION['user_id']]);

    header("Location: tickets.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier Ticket</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Modifier le ticket #<?= htmlspecialchars($ticket['id']) ?></h2>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Titre</label>
        <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($ticket['titre']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($ticket['description']) ?></textarea>
      </div>
      <button type="submit" class="btn btn-success">Enregistrer</button>
      <a href="mes_tickets.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</body>
</html>
