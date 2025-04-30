<?php
require_once 'Model/inscriptionModel.php';

class InscriptionController {
    private $model;
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
        $this->model = new InscriptionModel($db);
    }
    
    /**
     * Affiche le formulaire d'inscription
     */
    public function afficherFormulaire() {
        // Vérifier si l'utilisateur est déjà connecté
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        
        // Message d'erreur éventuel
        $erreur = isset($_SESSION['erreur_inscription']) ? $_SESSION['erreur_inscription'] : '';
        $donnees = isset($_SESSION['donnees_inscription']) ? $_SESSION['donnees_inscription'] : [];
        
        unset($_SESSION['erreur_inscription']);
        unset($_SESSION['donnees_inscription']);
        
        // Inclure la vue
        require_once 'Vue/inscriptionVue.php';
    }
    
    /**
     * Traite la soumission du formulaire d'inscription
     */
    public function traiterInscription() {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $userData = [
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'mot_de_passe' => $_POST['mot_de_passe'] ?? '',
                'confirmer_mot_de_passe' => $_POST['confirmer_mot_de_passe'] ?? '',
                'adresse' => trim($_POST['adresse'] ?? ''),
                'code_postal' => trim($_POST['code_postal'] ?? ''),
                'ville' => trim($_POST['ville'] ?? ''),
                'telephone' => trim($_POST['telephone'] ?? '')
            ];
            
            // Sauvegarder les données en session (sauf les mots de passe) pour les réafficher en cas d'erreur
            $donneesSauvegardees = $userData;
            unset($donneesSauvegardees['mot_de_passe']);
            unset($donneesSauvegardees['confirmer_mot_de_passe']);
            $_SESSION['donnees_inscription'] = $donneesSauvegardees;
            
            // Validation des données
            if (empty($userData['nom']) || empty($userData['prenom']) || empty($userData['email']) || 
                empty($userData['mot_de_passe']) || empty($userData['confirmer_mot_de_passe']) || 
                empty($userData['adresse']) || empty($userData['code_postal']) || 
                empty($userData['ville']) || empty($userData['telephone'])) {
                
                $_SESSION['erreur_inscription'] = "Tous les champs sont obligatoires";
                header('Location: index.php?action=inscription');
                exit;
            }
            
            // Validation de l'email
            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['erreur_inscription'] = "Format d'email invalide";
                header('Location: index.php?action=inscription');
                exit;
            }
            
            // Vérification de la correspondance des mots de passe
            if ($userData['mot_de_passe'] !== $userData['confirmer_mot_de_passe']) {
                $_SESSION['erreur_inscription'] = "Les mots de passe ne correspondent pas";
                header('Location: index.php?action=inscription');
                exit;
            }
            
            // Vérification de la complexité du mot de passe
            if (strlen($userData['mot_de_passe']) < 8) {
                $_SESSION['erreur_inscription'] = "Le mot de passe doit contenir au moins 8 caractères";
                header('Location: index.php?action=inscription');
                exit;
            }
            
            // Vérification si l'email existe déjà
            if ($this->model->emailExiste($userData['email'])) {
                $_SESSION['erreur_inscription'] = "Cet email est déjà utilisé";
                header('Location: index.php?action=inscription');
                exit;
            }
            
            // Inscription de l'utilisateur
            $userId = $this->model->inscrireUtilisateur($userData);
            
            if ($userId) {
                // Inscription réussie
                unset($_SESSION['donnees_inscription']);
                
                // Connexion automatique après inscription
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_nom'] = $userData['nom'];
                $_SESSION['user_prenom'] = $userData['prenom'];
                $_SESSION['user_role'] = 'client';
                
                // Redirection vers la page d'accueil
                header('Location: index.php?inscription=success');
                exit;
            } else {
                // Erreur lors de l'inscription
                $_SESSION['erreur_inscription'] = "Une erreur est survenue lors de l'inscription";
                header('Location: index.php?action=inscription');
                exit;
            }
        } else {
            // Si quelqu'un accède directement à cette action sans soumission POST
            header('Location: index.php?action=inscription');
            exit;
        }
    }
}
?>