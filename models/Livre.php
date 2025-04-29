<?php
require_once 'config\database.php';

class Livre {
    // Nouveautés (8 derniers livres)
    public static function getNouveautes() {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM livre ORDER BY id DESC LIMIT 8");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Produits phares (4 mieux notés)
    public static function getProduitsPhares() {
        $pdo = getPDO();
        $stmt = $pdo->query("
            SELECT l.*, AVG(a.note) as moyenne
            FROM livre l
            LEFT JOIN avis a ON l.id = a.livre_id
            GROUP BY l.id
            ORDER BY moyenne DESC
            LIMIT 4
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recherche autocomplétion
    public static function search($term) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT id, titre FROM livre WHERE titre LIKE ? LIMIT 5");
        $stmt->execute(['%' . $term . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tous les livres
    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM livre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Livres par catégorie
    public static function getByCategorie($categorie_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM livre WHERE categorie_id = ?");
        $stmt->execute([$categorie_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Détail d'un livre
    public static function getById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM livre WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Détail d'un livre + catégorie
    public static function getByIdWithDetails($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT l.*, c.nom AS categorie 
            FROM livre l 
            JOIN categorie c ON l.categorie_id = c.id 
            WHERE l.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Détail d'un livre + catégorie + moyenne avis
    public static function getByIdWithDetailsAndReviews($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT l.*, c.nom AS categorie, AVG(a.note) AS moyenne
            FROM livre l
            JOIN categorie c ON l.categorie_id = c.id
            LEFT JOIN avis a ON l.id = a.livre_id
            WHERE l.id = ?
            GROUP BY l.id
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
