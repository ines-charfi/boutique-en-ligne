<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique en ligne</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="/public/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/public/js/livre.js"></script>
    <script src="/public/js/boutique.js"></script>
</head>
<body>
    

<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="livre-detail">
        <img src="/public/images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
        <div>
            <h2><?= htmlspecialchars($livre['titre']) ?></h2>
            <p>Auteur : <?= htmlspecialchars($livre['auteur']) ?></p>
            <p>Année : <?= htmlspecialchars($livre['annee_publication']) ?></p>
            <p>Description : <?= htmlspecialchars($livre['description']) ?></p>
            <p>Catégorie : <?= htmlspecialchars($livre['categorie']) ?></p>
            <p>Stock : <?= htmlspecialchars($livre['stock']) ?> exemplaires</p>
            <p>Évaluation : <?= htmlspecialchars($livre['evaluation']) ?> / 5</p>
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
<?php include   '/../layout/footer.php'; ?>
</html>
