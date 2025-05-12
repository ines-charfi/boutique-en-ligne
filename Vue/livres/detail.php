<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique en ligne</title>
    <link rel="stylesheet" href="assets\css\style.css">
    <script src="assets\js\main.js"></script>
    <script src="assets\js\boutique.js"></script>
    <script src="assets\js\panier.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
<button class="btn" onclick="window.location.href='index.php?page=boutique'">Retour à la boutique</button>
<div class="container">
    <h1 class="text-center"><b>Détails du livre</b></h1><br>
    <p>Découvrez notre sélection de livres, de la littérature classique aux dernières nouveautés.</p><br>
    <div class="livre-detail">
        <img src="assets\images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
        <div class="livre-card">
            <h2><?= htmlspecialchars($livre['titre']) ?></h2>
            <p>Auteur : <?= htmlspecialchars($livre['auteur']) ?></p>
            <p>Année : <?= htmlspecialchars($livre['annee_publication']) ?></p>
            <p>Description : <?= htmlspecialchars($livre['description']) ?></p>
            <p>Stock : <?= htmlspecialchars($livre['stock']) ?> exemplaires</p>
            <p>Prix : <?= number_format($livre['prix'], 2) ?> €</p>
           <!-- Supprimer tout JavaScript inutile -->
            <form method="post" action="index.php?page=ajouter_panier">
                <input type="hidden" name="livre_id" value="<?= $livre['id'] ?>">
                <input type="number" name="quantite" value="1" min="1" max="<?= $livre['stock'] ?>">
                <button type="submit" class="btn">Ajouter au panier</button>
            </form>

            </div>
        </div>
    </div>
    <section class="avis-section">
    <h3>Avis des clients (<?= count($avis) ?>)</h3>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']) ?>
    <?php endif; ?>

   <!-- Formulaire d'avis -->
<?php if(isset($_SESSION['user_id'])): ?>
    <div class="avis-form">
        <h4>Donnez votre avis</h4>
        <form method="POST">
            <div class="form-group">
                <label>Note :</label>
                <select name="note" required>
                    <?php for($i=1; $i<=5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> étoiles</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Votre commentaire :</label>
                <input type="text" name="commentaire" required placeholder="Écrivez votre avis ici...">
            </div>
            <button type="submit" class="btn">Envoyer</button>
        </form>
    </div>
<?php else: ?>
    <h4><b>Votre avis compte pour notre progrès</b></h4>
<?php endif; ?>



    <!-- Liste des avis -->
    <div class="avis-list">
        <?php if(empty($avis)): ?>
            <p>Aucun avis pour le moment.</p>
        <?php endif; ?>
        <?php if(isset($_SESSION['user_id'])): ?>
            <h4>Vos avis précédents</h4>
        <?php endif; ?>
        <?php if(isset($_SESSION['avis'])): ?>
            <div class="alert success"><?= $_SESSION['avis'] ?></div>
            <?php unset($_SESSION['avis']) ?>
        <?php endif; ?>

        <?php foreach($avis as $a): ?>
        <div class="avis-card">
            <div class="avis-header">
                <span class="user"><?= htmlspecialchars($a['email']) ?></span>
                <div class="rating">
                    <?= str_repeat('★', $a['note']) ?>
                </div>
            </div>
            <p class="comment"><?= htmlspecialchars($a['commentaire']) ?></p>
           
        <?php endforeach; ?>
    </div>

    <div class="livre-similaire">
        <h3>Livres similaires</h3><br>
        <div class="livre-cards">
            <?php foreach($livres_similaires as $similaire): ?>
            <div class="livre-card">
                <img src="assets\images/<?= htmlspecialchars($similaire['image']) ?>" alt="<?= htmlspecialchars($similaire['titre']) ?>">
                <h4><?= htmlspecialchars($similaire['titre']) ?></h4>
                <p>Auteur : <?= htmlspecialchars($similaire['auteur']) ?></p>
                <p>Prix : <?= number_format($similaire['prix'], 2) ?> €</p>
                <form method="post" action="index.php?page=ajouter_panier">
    <!-- Utiliser l'ID du livre similaire -->
                    <input type="hidden" name="livre_id" value="<?= $similaire['id'] ?>">
                    <button type="submit" class="btn">Ajouter au panier</button>
                </form>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include 'Vue\bases\footer.php'; ?>
</body>
</html>