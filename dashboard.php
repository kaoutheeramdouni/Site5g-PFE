<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - 5G Vitrine</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <style>
    /* Styles pour le dashboard avec sidebar */
    #wrapper {
      display: flex;
      width: 100%;
    }
    #sidebar-wrapper {
      min-width: 250px;
      max-width: 250px;
      background-color: #f8f9fa;
      border-right: 1px solid #dee2e6;
    }
    #page-content-wrapper {
      width: 100%;
      padding: 20px;
    }
    .sidebar-heading {
      padding: 1rem;
      font-size: 1.2rem;
      font-weight: bold;
    }
    .list-group-item {
      border: none;
      border-bottom: 1px solid #dee2e6;
    }
    @media (max-width: 768px) {
      #sidebar-wrapper {
        max-width: 100%;
        min-width: 100%;
      }
    }
  </style>
</head>
<body>
<div id="wrapper">
  <!-- Sidebar -->
  <div id="sidebar-wrapper">
    <div class="sidebar-heading">5G Vitrine</div>
    <div class="list-group list-group-flush">
      <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
      <a href="tickets.php" class="list-group-item list-group-item-action">Mes Tickets</a>
      <a href="create_ticket.php" class="list-group-item list-group-item-action">Créer Ticket</a>
      <a href="discussion.php" class="list-group-item list-group-item-action">Discussion</a>
      <a href="logout.php" class="list-group-item list-group-item-action">Déconnexion</a>
    </div>
  </div>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
      <div class="container-fluid">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
        <span class="navbar-text ms-auto">
          Bienvenue, <?php echo htmlspecialchars($_SESSION['nom']); ?>
        </span>
      </div>
    </nav>
    <div class="container-fluid mt-4">
      <h1>Tableau de Bord</h1>
      <p>Depuis ce tableau de bord, vous pouvez consulter vos tickets, créer de nouveaux tickets, lancer des discussions, etc.</p>
      <!-- Ici, vous pourrez inclure ou charger dynamiquement le contenu des autres pages -->
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Script pour basculer l'affichage du sidebar sur petit écran
  document.getElementById("menu-toggle").addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("wrapper").classList.toggle("toggled");
  });
</script>
</body>
</html>
