<?php
class AuthMiddleware {
    public static function adminOnly() {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /connexion');
            
            exit;
        }
    }
}

// Utilisation dans les contrôleurs Admin :
AuthMiddleware::adminOnly();
