<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique commandes - NERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style1.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .container {
            margin: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php include  'Vue/bases/header.php'; ?>
<a href="index.php?page=boutique" class="btn">Retour à la boutique</a>
<a href="index.php?page=accueil" class="btn">Retour à l'accueil</a><br><br>

<div class="container">
    <h2>Mon historique de commandes</h2>
    <?php if (empty($commandes)) : ?>
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
                    <td><?= date('d/m/Y H:i', strtotime($commande['date'])) ?></td>
                    <td>
                        <?php
                        // Affiche le statut ou "payée" par défaut si vide
                        echo !empty($commande['statut']) ? htmlspecialchars($commande['statut']) : 'payée';
                        ?>
                    </td>
                    <td><?= number_format($commande['montant_total'], 2) ?> €</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<?php include  'Vue/bases/footer.php'; ?>
</body>
</html>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 