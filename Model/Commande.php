<?php
require_once 'config/database.php';
require_once 'model/Livre.php';

class Commande
{
    // Créer une nouvelle commande et ses lignes
    public static function create($user_id, $panier) {
        $pdo = getPDO();
        $pdo->beginTransaction();
    
        try {
            // Calcul du montant total
            $total = 0;
            foreach ($panier as $livre_id => $quantite) {
                $livre = Livre::getById($livre_id);
                $total += $livre['prix'] * $quantite;
            }
    
            // Insertion dans la commande (nom de colonne corrigé)
            $stmt = $pdo->prepare("INSERT INTO commande (userid, date, statut, montanttotal) VALUES (?, NOW(), 'validée', ?)");
            $stmt->execute([$user_id, $total]);
            $commande_id = $pdo->lastInsertId();
    
            // Insertion des lignes de commande
            foreach ($panier as $livre_id => $quantite) {
                $livre = Livre::getById($livre_id);
                $stmt = $pdo->prepare("INSERT INTO lignecommande (commandeid, livreid, quantite, prixunitaire) VALUES (?, ?, ?, ?)");
                $stmt->execute([$commande_id, $livre_id, $quantite, $livre['prix']]);
    
                // Mise à jour du stock
                $new_stock = $livre['stock'] - $quantite;
                $stmt = $pdo->prepare("UPDATE livre SET stock = ? WHERE id = ?");
                $stmt->execute([$new_stock, $livre_id]);
            }
    
            $pdo->commit();
            return true;
    
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception("Erreur création commande: " . $e->getMessage());
        }
    }
    
    // Méthode getByUserId corrigée
    public static function getByUserId($user_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM commande WHERE userid = ? ORDER BY date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Méthode getById corrigée
    public static function getById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM commande WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
      // Retrieve orders by user ID
      public static function getByUser($user_id) {
        $database = new Database(); // Create an instance of the Database class
        $db = $database->getConnection(); // Call the non-static method on the instance
        $stmt = $db->prepare("SELECT * FROM commande WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function countAll() {
        $database = new Database();
        $db = $database->getConnection();
        $query = $db->query("SELECT COUNT(*) as total FROM commandes");
        $result = $query->fetch();
        return $result['total'];
    }

    public function delete($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM commande WHERE id = ?");
    return $stmt->execute([$id]);
}

    public function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM commande");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdWithDetails($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT c.*, u.email AS user_email, l.titre, lc.quantité, lc.prix_unitaire
            FROM commande c
            JOIN user u ON c.user_id = u.id
            LEFT JOIN lignecommande lc ON c.id = lc.commande_id
            LEFT JOIN livre l ON lc.livre_id = l.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

    

    