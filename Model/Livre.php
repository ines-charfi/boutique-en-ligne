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
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recherche autocomplétion
    // Removed duplicate search method to avoid redeclaration error.
    // Removed duplicate getAll method to avoid redeclaration error.
    // Removed duplicate getByCategorie method to avoid redeclaration error.

    // Tous les livres
    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM livre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Livres par catégorie
    // Removed duplicate getByCategorie method to avoid redeclaration error.

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
    public static function getByIds(array $ids) {
        // Assuming a database connection is available
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT * FROM livres WHERE id IN ($placeholders)";
        $database = new Database();
        $stmt = $database->getConnection()->prepare($query);
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return books as an associative array
    }
    public static function getSimilaires($categorie_id, $exclude_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM livre WHERE categorie_id = ? AND id != ? LIMIT 5");
        $stmt->execute([$categorie_id, $exclude_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Removed duplicate ajouterAvis method to avoid redeclaration error.
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
    }
    public static function getPaginated($offset, $limit) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM livre LIMIT ?, ?");
        $stmt->bindValue(1, (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function countAll() {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT COUNT(*) FROM livre");
        return $stmt->fetchColumn();
    }
    public static function getPaginatedByCategorie($categorie_id, $offset, $limit) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM livre WHERE categorie_id = ? LIMIT ?, ?");
        $stmt->bindValue(1, $categorie_id, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(3, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function countByCategorie($categorie_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM livre WHERE categorie_id = ?");
        $stmt->execute([$categorie_id]);
        return $stmt->fetchColumn();
    }
    public static function search($term) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT id, titre, image FROM livre WHERE titre LIKE ? LIMIT 5");
        $stmt->execute(['%' . $term . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
 // Dans Livre.php
public static function getByCategorie($categorie_id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM livre WHERE categorieid = ?"); // Nom exact de la colonne
    $stmt->execute([$categorie_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    
        public static function getByCategorieAndId($categorie_id, $livre_id) {
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT * FROM livre WHERE categorieid = ? AND id = ?"); // Nom exact de la colonne
            $stmt->execute([$categorie_id, $livre_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        // Removed duplicate create method to avoid redeclaration error.
        
// Removed duplicate search method to avoid redeclaration error.
public static function getAllWithCategories() {
    $pdo = getPDO();
    $stmt = $pdo->query("
        SELECT l.*, c.nom as categorie 
        FROM livre l
        LEFT JOIN categorie c ON l.categorieid = c.id
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function create($data) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        INSERT INTO livre 
        (titre, auteur, prix, stock, categorieid, image)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    return $stmt->execute([
        $data['titre'],
        $data['auteur'],
        $data['prix'],
        $data['stock'],
        $data['categorieid'],
        $data['image']
    ]);
}

public static function delete($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM livre WHERE id = ?");
    return $stmt->execute([$id]);
}
}


?>
