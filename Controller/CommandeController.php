<?php
require_once 'model/Commande.php';
require_once 'model/Livre.php';
require_once 'model/User.php';
require_once 'model/Categorie.php';
class CommandeController {

    public function panier() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit();
        }
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }
        $panier = [];
        foreach ($_SESSION['panier'] as $livre_id => $quantite) {
            $livre = Livre::getById($livre_id);
            if ($livre) {
                $panier[] = [
                    'titre' => $livre['titre'],
                    'quantite' => $quantite,
                    'prix' => $livre['prix']
                ];
            }
        }
        require 'Vue/commandes/panier.php';
    }

  // Dans CommandeController.php
  public function ajouterPanier() {
    session_start(); // Si pas déjà présent
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérification utilisateur connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit();
        }

        // Initialisation panier
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        // Récupération données
        $livre_id = (int)$_POST['livre_id'];
        $quantite = (int)$_POST['quantite'];

        // Validation données
        if ($livre_id < 1 || $quantite < 1) {
            $_SESSION['error'] = "Données invalides";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Vérification stock
        $livre = Livre::getById($livre_id);
        if (!$livre || $quantite > $livre['stock']) {
            $_SESSION['error'] = "Stock insuffisant";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Mise à jour panier
        $_SESSION['panier'][$livre_id] = isset($_SESSION['panier'][$livre_id]) 
            ? $_SESSION['panier'][$livre_id] + $quantite 
            : $quantite;

        // Redirection
        header('Location: index.php?page=panier');
        exit();
    }

    header('Location: index.php?page=boutique');
    exit();
}


public function validerCommande() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=connexion');
        exit();
    }
    
    try {
        // Appel corrigé avec les bons paramètres
        Commande::create($_SESSION['user_id'], $_SESSION['panier']);
        unset($_SESSION['panier']);
        header('Location: index.php?page=confirmation');
        exit();
        
    } catch (Exception $e) {
        error_log("ERREUR: " . $e->getMessage());
        $_SESSION['error'] = "Erreur technique. Veuillez réessayer.";
        header('Location: index.php?page=panier');
        exit();
    }
}




    public function confirmation() {
        require 'Vue/commandes/confirmation.php';
    }

    public function historique() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit();
        }
        
        $commandes = Commande::getByUserId($_SESSION['user_id']);
        require 'Vue/commandes/historique.php';
}
public function clearPanier() {
    if (isset($_SESSION['panier'])) {
        unset($_SESSION['panier']);
    }
    header('Location: index.php?page=panier');
    exit();
}

}
?>