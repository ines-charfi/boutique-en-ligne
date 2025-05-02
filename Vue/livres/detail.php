<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique en ligne</title>
    <link rel="stylesheet" href="assets\css\style.css">
    <script src="assets\js\main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
<button class="btn" onclick="window.location.href='index.php?page=boutique'">Retour à la boutique</button>
<div class="container">
    <h1 class="text-center">Détails du livre</h1><br>
    <p>Découvrez notre sélection de livres, de la littérature classique aux dernières nouveautés.</p><br>
    <div class="livre-detail">
        <img src="assets\images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
        <div>
            <h2><?= htmlspecialchars($livre['titre']) ?></h2>
            <p>Auteur : <?= htmlspecialchars($livre['auteur']) ?></p>
            <p>Année : <?= htmlspecialchars($livre['annee_publication']) ?></p>
            <p>Description : <?= htmlspecialchars($livre['description']) ?></p>
            <p>Stock : <?= htmlspecialchars($livre['stock']) ?> exemplaires</p>
            <p>Prix : <?= number_format($livre['prix'], 2) ?> €</p>
            <form method="post" action="index.php?page=ajouter_panier">
                <input type="hidden" name="livre_id" value="<?= $livre['id'] ?>">
                <input type="number" name="quantite" value="1" min="1" max="<?= $livre['stock'] ?>">
                <button type="submit" class="btn">Ajouter au panier</button>
            </form>
        </div>
    </div>
</div>



</body>
 <?php include   'Vue\bases\footer.php'; ?>
</html>
