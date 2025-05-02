<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique commandes - NERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
<?php include  'Vue\bases\header.php'; ?>

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
                    <td><?= htmlspecialchars($commande['date']) ?></td>
                    <td><?= htmlspecialchars($commande['statut']) ?></td>
                    <td><?= number_format($commande['montant_total'], 2) ?> €</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<?php include  'Vue\bases\footer.php'; ?>
</body>
</html>
