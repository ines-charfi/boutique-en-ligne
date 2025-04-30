<?php
require_once __DIR__ . 'Model/connexionModel.php';

class ConnexionController {
    private $model;
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
        $this->model = new ConnexionModel($db);
    }
    
    /**
     * Affiche le formulaire de connexion
     */
    public function afficherFormulaire() {
        // Vérifier si l'utilisateur est déjà connecté
        if (isset($_SESSION['user_id'])) {
            // Rediriger vers la page d'accueil ou le tableau de bord
            header('Location: index.php');
            exit;
        }
        
        // Message d'erreur éventuel
        $erreur = isset($_SESSION['erreur_connexion']) ? $_SESSION['erreur_connexion'] : '';
        unset($_SESSION['erreur_connexion']);
        
        // Inclure la vue
        require_once 'Vue/connexionVue.php';
    }
    
    /**
     * Traite la soumission du formulaire de connexion
     */
    public function traiterConnexion() {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validation basique
            if (empty($email) || empty($password)) {
                $_SESSION['erreur_connexion'] = "Tous les champs sont obligatoires";
                header('Location: index.php?action=connexion');
                exit;
            }
            
            // Vérification des identifiants
            $utilisateur = $this->model->verifierIdentifiants($email, $password);
            
            if ($utilisateur) {
                // Connexion réussie
                $_SESSION['user_id'] = $utilisateur['id'];
                $_SESSION['user_nom'] = $utilisateur['nom'];
                $_SESSION['user_prenom'] = $utilisateur['prenom'];
                $_SESSION['user_role'] = $utilisateur['role'] ?? 'client';
                
                // Redirection vers la page d'accueil ou le tableau de bord
                header('Location: index.php');
                exit;
            } else {
                // Connexion échouée
                $_SESSION['erreur_connexion'] = "Email ou mot de passe incorrect";
                header('Location: index.php?action=connexion');
                exit;
            }
        } else {
            // Si quelqu'un accède directement à cette action sans soumission POST
            header('Location: index.php?action=connexion');
            exit;
        }
    }
    
    /**
     * Déconnecte l'utilisateur
     */
    public function deconnexion() {
        // Détruire toutes les variables de session
        $_SESSION = array();
        
        // Si un cookie de session est utilisé, le détruire
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Détruire la session
        session_destroy();
        
        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit;
    }
}
?>