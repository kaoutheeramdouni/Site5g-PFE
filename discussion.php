<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php");
    exit();
}
require_once 'db.php';

// Insertion d'un nouveau message si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO messages (user_id, message, date_creation, is_from_support) VALUES (?, ?, NOW(), 0)");
        $stmt->execute([$_SESSION['user_id'], $message]);
        // Redirection pour éviter la réinsertion en cas de refresh
        header("Location: discussion.php");
        exit();
    } else {
        $error = "Veuillez écrire un message.";
    }
}

// Récupérer les messages de la discussion de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM messages WHERE user_id = ? ORDER BY date_creation ASC");
$stmt->execute([$_SESSION['user_id']]);
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Discussion - 5G Vitrine</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <style>
    .message-container {
      max-height: 400px;
      overflow-y: auto;
      background: #f1f1f1;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .message {
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 5px;
    }
    .message.user {
      background-color: #d1e7dd;
      text-align: right;
    }
    .message.support {
      background-color: #f8d7da;
      text-align: left;
    }
  </style>
</head>
<body>
 
  <div class="container mt-5">
    <h2>Discussion avec le Support</h2>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <div class="message-container mb-3">
      <?php if (count($messages) > 0): ?>
        <?php foreach ($messages as $msg): ?>
          <div class="message <?php echo ($msg['is_from_support'] == 1) ? 'support' : 'user'; ?>">
            <small><?php echo htmlspecialchars($msg['date_creation']); ?></small><br>
            <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Aucun message pour le moment.</p>
      <?php endif; ?>
    </div>
    <form action="discussion.php" method="post">
      <div class="mb-3">
        <label for="message" class="form-label">Votre Message</label>
        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Écrivez votre message ici" required></textarea>
      </div>
      <button type="submit" class="btn btn-info">Envoyer</button>
      <a href="dashboard.php" class="btn btn-secondary">Retour Dashboard</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
