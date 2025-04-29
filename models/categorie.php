<?php
require_once  'config\database.php';

class Categorie {
    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM categorie");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
