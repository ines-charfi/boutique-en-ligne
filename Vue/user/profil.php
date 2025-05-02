<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil - NERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
    
</head>
<body>
<?php include  'Vue\bases\header.php'; ?>

<div class="container">
    <h2>Mon profil</h2>
    <p>Email : <?= htmlspecialchars($user['email']) ?></p>
    <p>Rôle : <?= htmlspecialchars($user['role']) ?></p>
    <a href="index.php?page=historique_commandes" class="btn">Voir mon historique de commandes</a>
    <a href="index.php?page=deconnexion" class="btn">Déconnexion</a>
</div>

<?php include  'Vue\bases\footer.php'; ?>
</body>
</html>
