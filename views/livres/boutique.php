<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique en ligne</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/boutique.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
    <h1>Bienvenue à notre librairie en ligne NERINAL BOOK</h1>
    <p>Découvrez notre sélection de livres, de la littérature classique aux dernières nouveautés.</p>
    <p>Nous avons quelque chose pour chaque lecteur.</p>
    <p>Parcourez notre collection et trouvez votre prochain livre préféré !</p>
<?php include __DIR__ . 'views\layout\header.php'; ?>

<div class="container">
    <h2>Notre sélection pour tous !</h2>
    <div class="filtre-categories">
        <button class="btn-filtre" data-id="0">Toutes les catégories</button>
        <?php foreach($categories as $cat): ?>
            <button class="btn-filtre" data-id="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></button>
        <?php endforeach; ?>
    </div>
    <div id="livres-grid" class="books-grid">
        <?php foreach($livres as $livre): ?>
            <div class="book-card">
                <img src="/public/images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                <p><?= htmlspecialchars($livre['auteur']) ?></p>
                <p><?= htmlspecialchars($livre['description']) ?></p>
                <p><?= htmlspecialchars($livre['categorie']) ?></p>
                <p><?= htmlspecialchars($livre['date_publication']) ?></p>
                <div class="price"><?= number_format($livre['prix'], 2) ?> €</div>
                <a href="index.php?page=livre_detail&id=<?= $livre['id'] ?>" class="btn">Voir détail</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


</body>
    <?php include 'views\layout\footer.php'; ?>
</html>