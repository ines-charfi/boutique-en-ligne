<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique en ligne</title>
    <link rel="stylesheet" href="assets\css\style1.css">
    <script src="assets/js/boutique.js"></script>
    <script scr="assets/js/filters.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
    
<?php include  'Vue\bases\header.php'; ?>
<button class="btn" onclick="window.location.href='index.php'">Retour à l'accueil</button>

<div class="container">
    <h2>Notre sélection pour tous !</h2><BR>
    <div class="filtre-categories">
    <button class="btn-filtre" data-id="0">Toutes les catégories</button>
    <?php foreach($categories as $cat): ?>
        <button class="btn-filtre" data-id="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></button>
    <?php endforeach; ?>
</div>


    <div id="livres-grid" class="books-grid">
        <?php foreach($livres as $livre): ?>
            <div class="book-card">
                <img src="assets/images\<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                <p><?= htmlspecialchars($livre['auteur']) ?></p>
           
               

                <div class="price"><?= number_format($livre['prix'], 2) ?> €</div><br>
                <a href="index.php?page=livre_detail&id=<?= $livre['id'] ?>" class="btn">Voir détail</a>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Pagination -->
<div class="pagination">
<?php for($i=1; $i<=$nbPages; $i++): ?>
    <a href="index.php?page=boutique<?= $categorie_id ? '&categorie_id=' . $categorie_id : '' ?>&page_num=<?= $i ?>"
       class="<?= ($i == $page) ? 'active' : '' ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>

</div>
    
       
</div>


</body>
    <?php include 'Vue\bases\footer.php'; ?>
</html>