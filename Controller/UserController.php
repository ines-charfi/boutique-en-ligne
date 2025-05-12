<?php
require_once 'model/User.php';
session_start();
require_once 'model/Categorie.php';
class UserController {
    public function inscription() {
        $erreur = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm = $_POST['confirmer_mot_de_passe'];

            if ($password !== $confirm) {
                $erreur = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($password) < 8) {
                $erreur = "Le mot de passe doit contenir au moins 8 caractères.";
            } elseif (User::getByEmail($email)) {
                $erreur = "Cet email est déjà utilisé.";
            } else {
                if (User::register($email, $password)) {
                    header('Location: index.php?page=connexion');
                    exit();
                } else {
                    $erreur = "Erreur lors de l'inscription.";
                }
            }
        }
        require 'Vue/user/inscription.php';
    }

    public function connexion() {
        $erreur = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = User::login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
    
                // Redirection selon le rôle
                if ($user['role'] === 'admin') {
                    header('Location: index.php?page=admin_dashboard');
                    exit();
                } else {
                    header('Location: index.php?page=boutique');
                    exit();
                }
            } else {
                $erreur = "Identifiants incorrects.";
            }
        }
        require 'Vue/user/connexion.php';
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
        require 'Vue/user/profil.php';
    }
}
?>
