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
    
<?php include 'Vue/bases/header.php'; ?>
<?php include 'Vue/bases/nav-admin.php'; ?>

<div class="container">
    <h2>Liste des utilisateurs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($utilisateurs as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <a href="index.php?page=edit_user&id=<?= $user['id'] ?>" class="btn btn-warning">Modifier</a>
                    <a href="index.php?page=delete_user&id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'Vue/bases/footer.php'; ?>
</body>
</html>