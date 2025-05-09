<?php
require_once  'config\database.php';

class Categorie {
    public static function getAll() {
        $pdo = getPDO();
        return $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
