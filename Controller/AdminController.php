<?php
class AdminController {
    private function checkAdmin() {
     
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=connexion');
            exit();
        }
    }

    public function dashboard() {
        $this->checkAdmin();
        require 'Vue/admin/dashboard.php';
    }

    // Gestion des livres
    public function livres() {
        $this->checkAdmin();
        $livres = Livre::getAllWithCategories();
        require 'Vue/admin/livres.php';
    }

    public function addLivre() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => htmlspecialchars($_POST['titre']),
                'auteur' => htmlspecialchars($_POST['auteur']),
                'prix' => floatval($_POST['prix']),
                'stock' => intval($_POST['stock']),
                'categorieid' => intval($_POST['categorieid']),
                'image' => $this->uploadImage()
            ];
            
            if (Livre::create($data)) {
                header('Location: index.php?page=admin_livres');
                exit();
            }
        }
        $categories = Categorie::getAll();
        require 'Vue/admin/add-livre.php';
    }

    private function uploadImage() {
        // Implémentez l'upload d'image ici
        return 'default.jpg';
    }

    public function deleteLivre() {
        $this->checkAdmin();
        if (isset($_GET['id'])) {
            Livre::delete(intval($_GET['id']));
            header('Location: index.php?page=admin_livres');
            exit();
        }
    }

    // Gestion des catégories
    public function categories() {
        $this->checkAdmin();
        $categories = Categorie::getHierarchy();
        require 'Vue/admin/categories.php';
    }

    public function editCategorie() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Categorie::update(
                intval($_POST['id']),
                htmlspecialchars($_POST['nom']),
                intval($_POST['parentid'])
            );
            header('Location: index.php?page=admin_categories');
            exit();
        }
    }
    public function admin_dashboard() {
        // Vérifier que l'utilisateur est admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=connexion');
            exit();
        }
    
        // Récupérer les statistiques principales
        $totalLivres = Livre::countAll();
        $totalCommandes = Commande::countAll();
        $totalUtilisateurs = User::countAll();
        $totalAvis = Avis::countAll();
    
        // Charger la vue du dashboard admin
        require 'Vue/admin/dashboard.php';
    }
    public function utilisateurs() {
        // Sécurité : accès réservé à l'admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=connexion');
            exit();
        }
    
        // Récupérer tous les utilisateurs
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT id, email, role FROM user");
        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Afficher la vue
        require 'Vue/admin/utilisateurs.php';
    }
    public function deleteUser() {
        // Sécurité : accès réservé à l'admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=connexion');
            exit();
        }
    
        // Supprimer l'utilisateur
        if (isset($_GET['id'])) {
            User::delete(intval($_GET['id']));
            header('Location: index.php?page=admin_utilisateurs');
            exit();
        }
    }    
    
}
?>
