<?php
require_once   '/../../config/database.php';

class Utilisateur {
    public static function register($email, $password, $role = 'user') {
        $pdo = getPDO();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO user (email, password, role) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $hash, $role]);
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
}
?>
