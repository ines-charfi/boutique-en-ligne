<?php
require_once __DIR__ . '/../Models/Livre.php';

class AccueilController {
    public function index() {
        $nouveautes = Livre::getNouveautes();
        $phares = Livre::getProduitsPhares();
        require __DIR__ . '/../Views/livres/accueil.php';
    }

    // Route AJAX pour l'autocomplétion
    public function autocomplete() {
        header('Content-Type: application/json');
        if (isset($_GET['term'])) {
            $results = Livre::search($_GET['term']);
            echo json_encode($results);
        }
        exit;
    }
}
?>
