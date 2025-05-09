<?php

require_once 'model/Livre.php';
require_once 'model/User.php';
require_once 'model/Categorie.php';
require_once 'model/Commande.php';
class CommandeController {
    // Page de confirmation de commande
    public function confirmation() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $panier = $_SESSION['panier'] ?? [];

            if (!empty($panier)) {
                Commande::create($user_id, $panier);
                unset($_SESSION['panier']); // Vider le panier après la commande
                header('Location: index.php?page=confirmation');
                exit();
            }
        }

        require 'Vue/commande/confirmation.php';
    }
    public function panier() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit();
        }
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }   
        // Logic for displaying the shopping cart
        echo "This is the shopping cart page.";
    }
// Removed duplicate method declaration
// Page de validation de commande

public function ajouterPanier() {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }
    $livre_id = $_POST['livre_id'];
    $quantite = $_POST['quantite'];
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