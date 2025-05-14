<?php include 'Vue/bases/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h2 class="mb-0">✅ Commande validée !</h2>
        </div>
        
        <div class="card-body">
            <h3 class="text-primary">Récapitulatif de la commande #<?= $_GET['id'] ?></h3>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande['date'])) ?></p>
                    <p><strong>Statut :</strong> <span class="badge bg-success"><?= $commande['statut'] ?></span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Client :</strong> <?= htmlspecialchars($commande['email']) ?></p>
                    <p><strong>Total :</strong> <?= number_format($commande['montant_total'], 2) ?> €</p>
                </div>
            </div>

            <h4>Articles commandés :</h4>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Livre</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= htmlspecialchars($article['titre']) ?></td>
                        <td><?= $article['quantité'] ?></td>
                        <td><?= number_format($article['prix_unitaire'], 2) ?> €</td>
                        <td><?= number_format($article['prix_unitaire'] * $article['quantité'], 2) ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center">
            <a href="index.php?page=boutique" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left"></i> Retour à la boutique
            </a>
            <a href="index.php?page=historique_commandes" class="btn btn-secondary btn-lg">
                <i class="fas fa-history"></i> Voir mon historique de commandes
            </a>
        </div>
    </div>
</div>

<?php include 'Vue/bases/footer.php'; ?>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>