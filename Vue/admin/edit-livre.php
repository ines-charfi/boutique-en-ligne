<?php include 'Vue/bases/header.php'; ?><br>
<a href="index.php?page=admin_livres" class="btn btn-primary">Retour à la liste des livres</a>
<br><br>

<div class="container mt-4">
    <h2>Modifier un livre</h2>
    <form method="post" action="index.php?page=edit_livre&id=<?= $livre['id'] ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>
        </div>
        <div class="form-group">
            <label for="auteur">Auteur :</label>
            <input type="text" class="form-control" id="auteur" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>
        </div>
      
        <div class="form-group">
            <label for="annee_publication">Année de publication :</label>
            <input type="number" class="form-control" id="annee_publication" name="annee_publication" min="0" value="<?= htmlspecialchars($livre['annee_publication'] ?? '') ?>" required>

        </div>
      
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea class="form-control" id="description" name="description"><?= htmlspecialchars($livre['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="prix">Prix (€) :</label>
            <input type="number" class="form-control" id="prix" name="prix" step="0.01" min="0" value="<?= htmlspecialchars($livre['prix']) ?>" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock :</label>
            <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?= htmlspecialchars($livre['stock']) ?>" required>
        </div>
        <div class="form-group">
            <label for="image">Image (nom de fichier ou URL) :</label>
            <input type="text" class="form-control" id="image" name="image" value="<?= htmlspecialchars($livre['image']) ?>">
        </div>
        <div class="form-group">
            <label for="categorieid">Catégorie :</label>
            <select class="form-control" id="categorieid" name="categorieid" required>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= (isset($livre['categorieid']) && $cat['id'] == $livre['categorieid']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nom']) ?>
                    </option>

                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="index.php?page=admin_livres" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include 'Vue/bases/footer.php'; ?>
