<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategories" aria-controls="navbarCategories" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarCategories">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Accueil</a>
                </li>
                
                <?php
                // Vous pouvez récupérer dynamiquement les catégories depuis la base de données
                // Pour le moment, on utilise des catégories statiques
                $categories = [
                    ['id' => 1, 'nom' => 'Électronique'],
                    ['id' => 2, 'nom' => 'Mode'],
                    ['id' => 3, 'nom' => 'Maison & Jardin'],
                    ['id' => 4, 'nom' => 'Sports & Loisirs'],
                ];
                
                foreach ($categories as $categorie) {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="index.php?action=categorie&id=' . $categorie['id'] . '">' . htmlspecialchars($categorie['nom']) . '</a>';
                    echo '</li>';
                }
                ?>
                
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=promotions">Promotions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=nouveautes">Nouveautés</a>
                </li>
            </ul>
        </div>
    </div>
</nav>