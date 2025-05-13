<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="assets\css\style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>

</head>
<body>
<?php include  'Vue\bases\header.php'; ?>

<div class="container">
    <h2>Tableau de bord administrateur</h2>
    <ul>
        <li><a href="index.php?page=admin_livres">Gestion des livres</a></li>
        <li><a href="index.php?page=admin_categories">Gestion des catégories</a></li>
        <li><a href="index.php?page=admin_utilisateurs">Gestion des utilisateurs</a></li>
        <li><a href="index.php?page=admin_commandes">Gestion des commandes</a></li>
        <li><a href="index.php?page=admin_avis">Gestion des avis</a></li>
    </ul>
</div>

<?php include  'Vue\bases\footer.php'; ?>
</body>
</html>
