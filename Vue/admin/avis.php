<?php include 'Vue/bases/header.php'; ?><br>
<a href="index.php?page=admin_dashboard" class="btn btn-primary">Retour au tableau de bord</a>
<br><br>

<div class="container mt-4">
    <h2>Gestion des avis clients</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Livre</th>
                <th>Utilisateur</th>
                <th>Note</th>
                <th>Commentaire</th>
                <th>Modéré</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($avis as $a): ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= htmlspecialchars($a['livre_titre'] ?? 'Livre inconnu') ?></td>
                <td><?= htmlspecialchars($a['utilisateur_email'] ?? 'Utilisateur inconnu') ?></td>
                <td><?= intval($a['note']) ?> / 5</td>
                <td><?= htmlspecialchars($a['commentaire']) ?></td>
                <td>
                    <?php if (isset($a['modere']) && $a['modere']): ?>
                        <span class="badge badge-success">Oui</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Non</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (empty($a['modere'])): ?>
                        <a href="index.php?page=moderate_avis&id=<?= $a['id'] ?>" class="btn btn-sm btn-success">Valider</a>
                    <?php endif; ?>
                    <a href="index.php?page=delete_avis&id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet avis ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'Vue/bases/footer.php'; ?>
