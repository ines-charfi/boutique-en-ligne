<?php
require_once 'model\User.php';

class UserController {
    public function inscription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            if (User::register($email, $password)) {
                $_SESSION['user_id'] = User::getByEmail($email)['id'];
                // Redirection vers la boutique après inscription
                header('Location: index.php?page=connexion');
                exit();
            }
        }
        require  'Vue\user\inscription.php';
    }

    public function connexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = User::login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                // Redirection vers la boutique après connexion

                header('Location: index.php?page=boutique');
                exit();
            }
        }
        require  'Vue\user\connexion.php';
    }

    
     
    public function deconnexion() {
        session_destroy();
        header('Location: index.php');
        exit();
    }

    public function profil() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit();
        }
        
        $user = User::getById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
            User::updatePassword($user['id'], $_POST['new_password']);
        }
        
        require __DIR__ . 'Vue/user/profil.php';
    }
}
?>
