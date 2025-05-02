<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - MERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
<?php include 'Vue\bases\header.php'; ?>

<div class="container">
    <h2>Votre panier</h2>
    <?php if (empty($panier)) : ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Livre</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
            <?php $total = 0; ?>
            <?php foreach ($panier as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['titre']) ?></td>
                    <td><?= $item['quantite'] ?></td>
                    <td><?= number_format($item['prix'], 2) ?> €</td>
                    <td><?= number_format($item['prix'] * $item['quantite'], 2) ?> €</td>
                </tr>
                <?php $total += $item['prix'] * $item['quantite']; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong><?= number_format($total, 2) ?> €</strong></td>
            </tr>
        </table>
        <form method="post" action="index.php?page=valider_commande">
            <button type="submit" class="btn">Valider la commande</button>
        </form>
    <?php endif; ?>
</div>

<?php include  'Vue\bases\footer.php'; ?>
</body>
</html>
