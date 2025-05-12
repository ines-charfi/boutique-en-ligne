<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style1.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
    
<?php include  'Vue\bases\header.php'; ?>
   

<div class="container">
    


    <!-- Section produits phares -->
    <section>
        <h1>Bienvenue à notre librairie en ligne NERINAL BOOK</h1>
        <p>Découvrez notre sélection de livres, de la littérature classique aux dernières nouveautés.</p>
        <p>Nous avons quelque chose pour chaque lecteur.</p>
        <p>Parcourez notre collection et trouvez votre prochain livre préféré !</p>
      

        <h2 class="text-center">Nos best-sellers</h2>
        <div class="books-grid">
            <?php foreach($phares as $livre): ?>
                <div class="book-card">
                    <img src="assets\images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                    <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                    <p><?= htmlspecialchars($livre['auteur']) ?></p>
                    <div class="price"><?= number_format($livre['prix'], 2) ?> €</div><br>
                    <a href="index.php?page=livre_detail&id=<?= $livre['id'] ?>" class="btn">Voir détail</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section nouveautés -->
    <section>
        <h2 class="text-center">Dernières sorties</h2>
        <div class="books-grid">
            <?php foreach($nouveautes as $livre): ?>
                <div class="book-card">
                    <img src="assets\images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                    <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                    <p><?= htmlspecialchars($livre['auteur']) ?></p>
                    <div class="price"><?= number_format($livre['prix'], 2) ?> €</div><br>
                    <a href="index.php?page=livre_detail&id=<?= $livre['id'] ?>" class="btn">Voir détail</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>



</body>
    <?php include  'Vue\bases\footer.php'; ?>
</html>
