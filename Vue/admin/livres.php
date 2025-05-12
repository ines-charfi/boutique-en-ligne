<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>

    <title>Document</title>
</head>
<body>
    

<?php include '../bases/header.php'; ?>

<div class="container mt-4">
    <h2>Gestion des Livres</h2>
    <a href="index.php?page=add_livre" class="btn btn-success mb-3">➕ Ajouter un livre</a>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livres as $livre): ?>
            <tr>
                <td><?= $livre['id'] ?></td>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['auteur']) ?></td>
                <td><?= number_format($livre['prix'], 2) ?> €</td>
                <td><?= $livre['stock'] ?></td>
                <td><?= $livre['categorie'] ?? 'Non catégorisé' ?></td>
                <td>
                    <a href="index.php?page=edit_livre&id=<?= $livre['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                    <a href="index.php?page=delete_livre&id=<?= $livre['id'] ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Êtes-vous sûr ?')">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../bases/footer.php'; ?>
<script src="assets/js/admin.js"></script>
</body>
</html>