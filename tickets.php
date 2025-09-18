<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php");
    exit();
}
require_once 'db.php';

// Récupérer les tickets de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY date_creation DESC");
$stmt->execute([$_SESSION['user_id']]);
$tickets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Tickets - 5G Vitrine</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>🎫 Mes Tickets</h2>
      <div>
        <a href="create_ticket.php" class="btn btn-primary me-2">
          <i class="bi bi-plus-circle"></i> Nouveau Ticket
        </a>
        <a href="dashboard.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Dashboard
        </a>
      </div>
    </div>

    <?php if (count($tickets) > 0): ?>
      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tickets as $ticket): ?>
            <tr>
              <td><?= htmlspecialchars($ticket['id']) ?></td>
              <td><?= htmlspecialchars($ticket['titre']) ?></td>
              <td><?= htmlspecialchars($ticket['description']) ?></td>
              <td><?= htmlspecialchars($ticket['date_creation']) ?></td>
              <td>
                <a href="edit_ticket.php?id=<?= $ticket['id'] ?>" class="btn btn-warning btn-sm me-1">
                  <i class="bi bi-pencil-square"></i> Modifier
                </a>
                <a href="delete_ticket.php?id=<?= $ticket['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Confirmer la suppression du ticket ?');">
                  <i class="bi bi-trash"></i> Supprimer
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-info">Aucun ticket trouvé.</div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
