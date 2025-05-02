<?php
require_once  'model\Livre.php';
require_once  'model\categorie.php';

class LivreController {
    // Page boutique
    public function boutique() {
        $categories = Categorie::getAll();
        $livres = Livre::getAll();
        require 'Vue\livres\boutique.php';
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
        require  'Vue\livres\detail.php';
    }
    public function ajouterAvis() {
        // Assuming you have a database connection and the necessary data from the form
        $livre_id = $_POST['livre_id'];
        $note = $_POST['note'];
        $commentaire = $_POST['commentaire'];
        $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO avis (livre_id, user_id, note, commentaire) VALUES (?, ?, ?, ?)");
        $stmt->execute([$livre_id, $user_id, $note, $commentaire]);
        // Optionally, you can also update the average rating of the book here
        $stmt = $pdo->prepare("UPDATE livre SET moyenne = (SELECT AVG(note) FROM avis WHERE livre_id = ?) WHERE id = ?");
        $stmt->execute([$livre_id, $livre_id]);
        // Redirect or show a success message
        // You can also return a JSON response if this is an AJAX request
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Avis ajouté avec succès.']);
    }
    public function ajouterPanier() {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }
        $livre_id = $_POST['livre_id'];
        $quantite = $_POST['quantite'];
        // Vérifier si le produit existe déjà
        if (isset($_SESSION['panier'][$livre_id])) {
            $_SESSION['panier'][$livre_id] += $quantite;
        } else {
            $_SESSION['panier'][$livre_id] = $quantite;
        }
        header('Location: index.php?page=boutique');
        exit;
    }
    public function validerCommande() {
        // Logic to validate the order
        echo "Commande validée avec succès.";
    }
    public function historique() {
        // Logic for displaying the order history
        echo "Displaying order history.";
    }
}
?>
