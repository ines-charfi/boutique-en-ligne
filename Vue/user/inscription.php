<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - NERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
<?php include  'Vue\bases\header.php'; ?>

<div class="container">
    <h2>Inscription</h2>
    <form method="POST" action="index.php?page=connexion">
        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" required class="form-control">
        </div>
        <div class="form-group">
            <label>Mot de passe :</label>
            <input type="password" name="password" required class="form-control">
        </div>
        <button type="submit" class="btn">S'inscrire</button>
    </form>
</div>


</body>
<?php include  'Vue\bases\footer.php'; ?>
</html>
