<?php
require_once  'Model\Livre.php';

class AccueilController {
    public function index() {
        $nouveautes = Livre::getNouveautes();
        $phares = Livre::getProduitsPhares();
        require  'Vue\livres\acceuil.php';
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
