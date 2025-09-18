<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom              = trim($_POST['nom']);
    $email            = trim($_POST['email']);
    $password         = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($nom) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email est déjà utilisé
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Hacher le mot de passe et insérer le nouvel utilisateur
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe, date_inscription) VALUES (?, ?, ?, NOW())");
            if ($stmt->execute([$nom, $email, $hashedPassword])) {
                // Inscription réussie : redirection vers la page de connexion
                header("Location: connect.php");
                exit();
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - 5G Vitrine</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <style>
    /* Styles personnalisés pour la page d'inscription */
    body {
      background-color: #f0f2f5;
    }
    .card {
      margin-top: 50px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-center">
          <h3>Inscription</h3>
        </div>
        <div class="card-body">
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <form action="inscription.php" method="post">
            <div class="mb-3">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" name="nom" id="nom" class="form-control" placeholder="Votre nom" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Adresse Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Votre email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mot de Passe</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Votre mot de passe" required>
            </div>
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirmer le Mot de Passe</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirmez votre mot de passe" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>
          </form>
        </div>
        <div class="card-footer text-center">
          Vous avez déjà un compte ? <a href="connect.php">Se connecter</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
