<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Rechercher l'utilisateur par email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Vérifier le mot de passe (en supposant un hachage avec password_hash)
            if (password_verify($password, $user['mot_de_passe'])) {
                // Authentification réussie : démarrer la session et rediriger vers le dashboard
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nom']     = $user['nom'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Utilisateur non trouvé.";
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
  <title>Se Connecter - 5G Vitrine</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <style>
    /* Styles personnalisés pour la page de connexion */
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
          <h3>Se Connecter</h3>
        </div>
        <div class="card-body">
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <form action="connect.php" method="post">
            <div class="mb-3">
              <label for="email" class="form-label">Adresse Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Votre email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mot de Passe</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Votre mot de passe" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Se Connecter</button>
            </div>
          </form>
        </div>
        <div class="card-footer text-center">
          Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
