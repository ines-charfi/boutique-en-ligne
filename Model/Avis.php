<?php
require_once 'config/database.php';

class Avis {
    // Ajouter un avis
    public static function create($livre_id, $user_id, $note, $commentaire) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            INSERT INTO avis (livre_id, user_id, note, commentaire, modere)
            VALUES (?, ?, ?, ?, 0)
        ");
        return $stmt->execute([$livre_id, $user_id, $note, $commentaire]);
    }

    // Récupérer les avis validés pour un livre
    public static function getValidatedForLivre($livre_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT a.*, u.email 
            FROM avis a
            JOIN user u ON a.user_id = u.id
            WHERE livre_id = ? AND modere = 1
            ORDER BY a.id DESC
        ");
        $stmt->execute([$livre_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les avis à modérer (admin)
    public static function getToModerate() {
        $pdo = getPDO();
        $stmt = $pdo->query("
            SELECT a.*, l.titre, u.email
            FROM avis a
            JOIN livre l ON a.livre_id = l.id
            JOIN user u ON a.user_id = u.id
            WHERE modere = 0
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modérer un avis (admin)
    public static function moderate($avis_id, $action) {
        $pdo = getPDO();
        if($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE avis SET modere = 1 WHERE id = ?");
        } else {
            $stmt = $pdo->prepare("DELETE FROM avis WHERE id = ?");
        }
        return $stmt->execute([$avis_id]);
    }
    // Récupérer la note moyenne d'un livre
    public static function getAverage($livre_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT AVG(note) as moyenne
            FROM avis
            WHERE livre_id = ? AND modere = 1
        ");
        $stmt->execute([$livre_id]);
        return $stmt->fetchColumn();
    }
 
        // Existing methods and properties
    
        public static function countAll() {
            $database = new Database();
            $db = $database->getConnection();
            $query = $db->query('SELECT COUNT(*) as total FROM avis');
            $result = $query->fetch();
            return $result['total'];
        }
 

    public static function delete($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM avis WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
 


    