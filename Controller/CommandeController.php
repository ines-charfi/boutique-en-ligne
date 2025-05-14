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
    // Vérifier que l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=connexion');
        exit();
    }

    // Récupérer le panier depuis la session
    $panier = $_SESSION['panier'] ?? [];
    if (empty($panier)) {
        $_SESSION['error'] = "Votre panier est vide.";
        header('Location: index.php?page=panier');
        exit();
    }

    $pdo = getPDO();
    $pdo->beginTransaction();

    try {
        // Calcul du montant total
        $montantTotal = 0;
        foreach ($panier as $livre_id => $quantite) {
            $livre = Livre::getById($livre_id);
            if ($livre) {
                $montantTotal += $livre['prix'] * $quantite;
            }
        }

        // Création de la commande (statut = "payée (simulation)")
        $stmt = $pdo->prepare("INSERT INTO commande (user_id, date, statut, montant_total) VALUES (?, NOW(), ?, ?)");
        $stmt->execute([$_SESSION['user_id'], 'payée (simulation)', $montantTotal]);
        $commandeId = $pdo->lastInsertId();

        // Insertion des lignes de commande
        foreach ($panier as $livre_id => $quantite) {
            $livre = Livre::getById($livre_id);
            if ($livre) {
                $stmt = $pdo->prepare("INSERT INTO lignecommande (commande_id, livre_id, quantité, prix_unitaire) VALUES (?, ?, ?, ?)");
                $stmt->execute([$commandeId, $livre_id, $quantite, $livre['prix']]);
            }
        }

        // Vider le panier
        unset($_SESSION['panier']);
        $pdo->commit();

        // Redirection vers la page de confirmation
        header('Location: index.php?page=confirmation_commande&id=' . $commandeId);
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Erreur lors de la validation de la commande : " . $e->getMessage();
        header('Location: index.php?page=panier');
        exit();
    }
}

public function confirmation() {
    // Vérifier l'existence de l'ID de commande
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php?page=panier');
        exit();
    }
    
    $commandeId = (int)$_GET['id'];
    $pdo = getPDO();
    
    // Récupérer les détails de la commande
    $stmt = $pdo->prepare("
        SELECT c.date, c.statut, c.montant_total, u.email 
        FROM commande c
        JOIN user u ON c.user_id = u.id
        WHERE c.id = ?
    ");
    // Correction de la requête pour utiliser le bon nom de colonne
    $stmt->execute([$commandeId]);
    $commande = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer les articles de la commande
    $stmt = $pdo->prepare("
        SELECT l.titre, lc.quantité, lc.prix_unitaire
        FROM lignecommande lc
        JOIN livre l ON lc.livre_id = l.id
        WHERE lc.commande_id = ?
    ");
    $stmt->execute([$commandeId]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require 'Vue/commandes/confirmation_commande.php';
}
public function historique() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=connexion');
        exit();
    }

    $pdo = getPDO();
    $stmt = $pdo->prepare("
        SELECT id, date, statut, montant_total 
        FROM commande 
        WHERE user_id = ? 
        ORDER BY date DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require 'Vue/commandes/historique_commandes.php';
}



public function clearPanier() {
    // Vérifier que l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=connexion');
        exit();
    }

    // Vider le panier
    unset($_SESSION['panier']);
    $_SESSION['success'] = "Votre panier a été vidé avec succès.";
    header('Location: index.php?page=panier');
    exit();
}
}
?>