<?php
require_once __DIR__ . '/../Models/Livre.php';
require_once __DIR__ . '/../Models/Categorie.php';

class LivreController {
    // Page boutique
    public function boutique() {
        $categories = Categorie::getAll();
        $livres = Livre::getAll();
        require __DIR__ . '/../Views/livres/boutique.php';
    }

    // AJAX : filtrer par catégorie
    public function filtrer() {
        header('Content-Type: application/json');
        $categorie_id = $_GET['categorie_id'] ?? 0;
        if ($categorie_id) {
            $livres = Livre::getByCategorie($categorie_id);
        } else {
            $livres = Livre::getAll();
        }
        echo json_encode($livres);
        exit;
    }

    // Page détail livre
    public function detail($id) {
        $livre = Livre::getById($id);
        require __DIR__ . '/../Views/livres/detail.php';
    }
}
?>
