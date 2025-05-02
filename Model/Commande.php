<?php
require_once  'config\database.php';

class Commande
{
    // Créer une nouvelle commande (retourne l'ID de la commande)
    public static function creer($user_id, $montant_total, $statut = 'panier')
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO commande (user_id, date, statut, montant_total) VALUES (?, NOW(), ?, ?)");
        $stmt->execute([$user_id, $statut, $montant_total]);
        return $pdo->lastInsertId();
    }

    // Ajouter une ligne de commande
    public static function ajouterLigne($commande_id, $livre_id, $quantite, $prix_unitaire)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO lignecommande (commande_id, livre_id, quantité, prix_unitaire) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$commande_id, $livre_id, $quantite, $prix_unitaire]);
    }

    // Récupérer toutes les commandes d'un utilisateur
    public static function getByUser($user_id)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM commande WHERE user_id = ? ORDER BY date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les lignes d'une commande
    public static function getLignes($commande_id)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT lc.*, l.titre, l.image 
            FROM lignecommande lc
            JOIN livre l ON lc.livre_id = l.id
            WHERE lc.commande_id = ?
        ");
        $stmt->execute([$commande_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une commande par son id
    public static function getById($commande_id)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM commande WHERE id = ?");
        $stmt->execute([$commande_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le statut d'une commande
    public static function updateStatut($commande_id, $statut)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE commande SET statut = ? WHERE id = ?");
        return $stmt->execute([$statut, $commande_id]);
    }
   
        // Existing code in the Commande class
    
        public static function create($user_id, $panier) {
            // Example implementation of the create method
            // This assumes you have a database connection setup
            $database = new Database(); // Create an instance of the Database class
            $db = $database->getConnection(); // Call the non-static method on the instance
    
            $stmt = $db->prepare("INSERT INTO commandes (user_id, date_commande) VALUES (?, NOW())");
            $stmt->execute([$user_id]);
            $commande_id = $db->lastInsertId();
    
            foreach ($panier as $livre_id => $quantite) {
                $stmt = $db->prepare("INSERT INTO commande_details (commande_id, livre_id, quantite) VALUES (?, ?, ?)");
                $stmt->execute([$commande_id, $livre_id, $quantite]);
            }
        }
    }

?>
