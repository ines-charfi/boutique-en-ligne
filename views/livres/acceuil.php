<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <!-- Barre de recherche -->
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Rechercher un livre...">
        <div id="autocomplete-results"></div>
    </div>

    <!-- Section produits phares -->
    <section>
        <h2>Nos best-sellers</h2>
        <div class="books-grid">
            <?php foreach($phares as $livre): ?>
                <div class="book-card">
                    <img src="/public/images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                    <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                    <p><?= htmlspecialchars($livre['auteur']) ?></p>
                    <div class="price"><?= number_format($livre['prix'], 2) ?> €</div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section nouveautés -->
    <section>
        <h2>Dernières sorties</h2>
        <div class="books-grid">
            <?php foreach($nouveautes as $livre): ?>
                <div class="book-card">
                    <img src="/public/images/<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                    <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                    <p><?= htmlspecialchars($livre['auteur']) ?></p>
                    <div class="price"><?= number_format($livre['prix'], 2) ?> €</div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
<script src="/public/assets/js/main.js"></script>
