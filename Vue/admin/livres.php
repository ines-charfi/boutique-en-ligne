<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets\css\style1.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>

    <title>Document</title>
</head>
<body>
    

<?php include 'Vue/bases/header.php'; ?><br>
<a href="index.php?page=admin_dashboard" class="btn btn-primary">Retour au tableau de bord</a>
<br>

<div class="container mt-4">
    <h2>Gestion des Livres</h2><br>
    <p>Voici la liste des livres disponibles dans la boutique. Vous pouvez ajouter, modifier ou supprimer des livres.</p><br>
    <a href="index.php?page=add_livre" class="btn btn-success mb-3">➕ Ajouter un livre</a><br>
<br>
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
            <!-- Boucle pour afficher les livres -->
<?php foreach ($livres as $livre): ?>
<tr>
    <td data-label="ID"><?= $livre['id'] ?></td>
    <td data-label="Titre"><?= htmlspecialchars($livre['titre']) ?></td>
    <td data-label="Auteur"><?= htmlspecialchars($livre['auteur']) ?></td>
    <td data-label="Prix"><?= number_format($livre['prix'], 2) ?> €</td>
    <td data-label="Stock"><?= $livre['stock'] ?></td>
    <td data-label="Catégorie"><?= $livre['categorie'] ?? 'Non catégorisé' ?></td>
    <td data-label="Actions">
        <a href="index.php?page=livre_detail&id=<?= $livre['id'] ?>" class="btn btn-sm btn-info">👁️</a>
        <a href="index.php?page=edit_livre&id=<?= $livre['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
        <a href="index.php?page=delete_livre&id=<?= $livre['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">🗑️</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>

      
    </table>
</div>

<?php include 'Vue/bases/footer.php'; ?>
<script src="assets/js/admin.js"></script>
</body>
</html>