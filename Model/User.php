<?php
require_once  'config\database.php';

class User {
    public static function register($email, $password) {
        $pdo = getPDO();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
        return $stmt->execute([$email, $hash]);
    }

    public static function login($email, $password) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public static function getById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePassword($id, $newPassword) {
        $pdo = getPDO();
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }


    // Existing methods and properties

    public static function getByEmail($email) {
        // Replace the following with actual database query logic
        $database = new Database();
        $db = $database->getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
