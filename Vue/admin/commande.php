<?php include 'Vue/bases/header.php'; ?><br>
<a href="index.php?page=admin_livres" class="btn btn-primary">Retour à la liste des livres</a>
<br><br>

<div class="container mt-4">
    <h2>Gestion des commandes</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Client</th>
                <th>Statut</th>
                <th>Montant total</th>
                <th>Livres commandés</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($commandes as $commande): ?>
            <tr>
                <td><?= $commande['id'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($commande['date'])) ?></td>
                <td><?= htmlspecialchars($commande['user_email']) ?></td>
                <td>
                    <span class="badge badge-<?= 
                        $commande['statut'] === 'payée' ? 'success' : 
                        ($commande['statut'] === 'expédiée' ? 'primary' : 'warning') 
                    ?>">
                        <?= htmlspecialchars($commande['statut']) ?>
                    </span>
                </td>
                <td><?= number_format($commande['montant_total'], 2) ?> €</td>
                <td>
                    <?php if (!empty($commande['livres'])): ?>
                        <ul style="padding-left: 18px;">
                            <?php foreach ($commande['livres'] as $livre): ?>
                                <li>
                                    <?= htmlspecialchars($livre['titre']) ?> 
                                    (x<?= $livre['quantité'] ?>) 
                                    - <?= number_format($livre['prix_unitaire'], 2) ?> €
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <em>Aucun livre</em>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="index.php?page=detail_commande&id=<?= $commande['id'] ?>" class="btn btn-info btn-sm">Détails</a>
                    <a href="index.php?page=delete_commande&id=<?= $commande['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette commande ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'Vue/bases/footer.php'; ?>
