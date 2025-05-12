<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - MERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/boutique.js"></script>
</head>
<body>
<?php include 'Vue\bases\header.php'; ?>

<div class="container">
    <h2>Commande validée !</h2>
    <p>Merci pour votre achat. Votre commande a été enregistrée.</p>
    <a href="index.php?page=boutique" class="btn">Retour à la boutique</a>
    <a href="index.php?page=historique" class="btn">Voir l'historique des commandes</a>
    <a href="index.php?page=accueil" class="btn">Retour à l'accueil</a>
    <form method="post" action="index.php?page=clear_panier">
    <button type="submit" class="btn">Vider le panier</button>
    </form>

</div>


<?php include  'Vue\bases\footer.php'; ?>
</body>
</html>
