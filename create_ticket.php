<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php");
    exit();
}
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);

    if (!empty($titre) && !empty($description)) {
        $stmt = $pdo->prepare("INSERT INTO tickets (user_id, titre, description, date_creation) VALUES (?, ?, ?, NOW())");
        if ($stmt->execute([$_SESSION['user_id'], $titre, $description])) {
            header("Location: tickets.php");
            exit();
        } else {
            $error = "Erreur lors de la création du ticket.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer Ticket - 5G Vitrine</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <style>
    body { background-color: #f8f9fa; }
  </style>
</head>
<body>

  <div class="container mt-5">
    <h2>Créer un Ticket</h2>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="create_ticket.php" method="post">
      <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre du ticket" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="Description du problème ou de la demande" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">Créer Ticket</button>
      <a href="dashboard.php" class="btn btn-secondary">Retour Dashboard</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
