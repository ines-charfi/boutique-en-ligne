<?php include 'Vue/bases/header.php'; ?><br>
<a href="index.php?page=admin_livres" class="btn btn-primary">Retour à la liste des livres</a>
<br><br>

<div class="container mt-4">
    <h2>Ajouter un livre</h2>
    <form method="post" action="index.php?page=add_livre" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="auteur">Auteur :</label>
            <input type="text" class="form-control" id="auteur" name="auteur" required>
        </div>
        
        <div class="form-group">
            <label for="annee_publication">Année de publication :</label>
            <input type="number" class="form-control" id="annee_publication" name="annee_publication" min="0">
        </div>
     
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="prix">Prix (€) :</label>
            <input type="number" class="form-control" id="prix" name="prix" step="0.01" min="0" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock :</label>
            <input type="number" class="form-control" id="stock" name="stock" min="0" required>
        </div>
        <div class="form-group">
            <label for="image">Image (nom de fichier ou URL) :</label>
            <input type="text" class="form-control" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="categorieid">Catégorie :</label>
            <select class="form-control" id="categorieid" name="categorieid" required>
                <option value="">Sélectionner une catégorie</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>

<?php include 'Vue/bases/footer.php'; ?>
