<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un avis - NERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style1.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
<?php include 'Vue\bases\header.php'; ?>

<div class="container">
    <h2>Laisser un avis pour <?= htmlspecialchars($livre['titre']) ?></h2>
    <form method="post" action="index.php?page=ajouter_avis&id=<?= $livre['id'] ?>">
        <label>Note :</label>
        <select name="note" required>
            <option value="">Choisir</option>
            <?php for ($i=1; $i<=5; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <label>Commentaire :</label>
        <textarea name="commentaire" required></textarea>
        <button type="submit" class="btn">Envoyer</button>
    </form>
</div>

<?php include  'Vue\bases\footer.php'; ?>
</body>
</html>
