<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil - NERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style1.css">
</head>
<body>
<?php include 'Vue/bases/header.php'; ?>

<div class="container">
    <a href="index.php" class="btn">Retour à l'accueil</a><br><br>
    <a href="index.php?page=boutique" class="btn">Retour à la boutique</a><br><br>
    <h2><u><b>Mon profil</b></u></h2><br>

    <!-- Récapitulatif des informations -->
    <div class="profil-info">
        <form method="post" action="index.php?page=profil">
            <label>Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <label>Adresse :</label>
            <input type="text" name="adresse" value="<?= htmlspecialchars($user['adresse'] ?? '') ?>" required>
            <button type="submit" class="btn">Mettre à jour</button>
        </form>
    </div><br>

    <!-- Formulaire de changement de mot de passe -->
    <div class="profil-mdp">
        <h3><u><b>Changer mon mot de passe</b></u></h3><br>
        <form method="post" action="index.php?page=profil">
            <input type="hidden" name="change_password" value="1">
            <label>Nouveau mot de passe :</label>
            <input type="password" name="new_password" required>
            <button type="submit" class="btn">Changer le mot de passe</button>
        </form>
    </div><br>

    <!-- Historique des commandes -->
    <div class="profil-commandes">
        <h3><b><u>Mon historique d’achats</b></u></h3><br>
        <?php if (empty($commandes)): ?>
            <p>Vous n'avez pas encore passé de commande.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Montant total</th>
                </tr>
                <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td><?= htmlspecialchars($commande['date']) ?></td>
                        <td><?= htmlspecialchars($commande['statut']) ?></td>
                        <td><?= number_format($commande['montant_total'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <!-- Lien vers le panier -->
    <div style="margin-top:2em;">
        <a href="index.php?page=panier" class="btn">Voir mon panier</a>
    </div>
</div>

<?php include 'Vue/bases/footer.php'; ?>
</body>
</html>

