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
        require 'Vue\admin\dashbord.php';
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
                'categorieid' => $_POST['categorieid'],
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
        require 'Vue/admin/categorie.php';
    }

    public function editCategorie() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Categorie::update(
                intval($_POST['id']),
                htmlspecialchars($_POST['nom']),
                intval($_POST['id'])
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
    public function commandes() {
    // Vérification du rôle admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?page=connexion');
        exit();
    }

    // Récupération des commandes avec jointures
    $pdo = getPDO();
    $stmt = $pdo->query("
        SELECT 
            c.id, 
            c.date, 
            c.statut, 
            c.montant_total AS montant_total, 
            u.email AS user_email,
            GROUP_CONCAT(CONCAT(l.titre, ' (x', lc.quantité, ')') SEPARATOR ', ') AS produits
        FROM commande c
        LEFT JOIN user u ON c.user_id = u.id
        LEFT JOIN lignecommande lc ON c.id = lc.commande_id
        LEFT JOIN livre l ON lc.livre_id = l.id
        GROUP BY c.id
        ORDER BY c.date DESC
    ");
    
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require 'Vue/admin/commande.php';
}
public function avis() {
    // Sécurité : accès réservé à l'admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?page=connexion');
        exit();
    }

    // Récupérer tous les avis avec info livre et utilisateur
    $pdo = getPDO();
    $stmt = $pdo->query("
        SELECT 
            a.id, 
            a.note, 
            a.commentaire, 
            a.modere,
            l.titre AS livre_titre,
            u.email AS user_email
        FROM avis a
        LEFT JOIN livre l ON a.livre_id = l.id
        LEFT JOIN user u ON a.user_id = u.id
        ORDER BY a.id DESC
    ");
    $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Afficher la vue admin des avis
    require 'Vue/admin/avis.php';
}
public function deleteAvis() {
    // Sécurité : accès réservé à l'admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?page=connexion');
        exit();
    }

    // Supprimer l'avis
    if (isset($_GET['id'])) {
        Avis::delete(intval($_GET['id']));
        header('Location: index.php?page=admin_avis');
        exit();
    }
   
    
}

public function editLivre() {
    // Sécurité : accès réservé à l'admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?page=connexion');
        exit();
    }

    // Récupérer l'ID du livre à modifier
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php?page=admin_livres');
        exit();
    }
    $livre_id = (int)$_GET['id'];

    $pdo = getPDO();

    // Si le formulaire est soumis, traiter la mise à jour
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $annee = $_POST['annee_publication'];
        $description = $_POST['description'];
        $prix = floatval($_POST['prix']);
        $stock = intval($_POST['stock']);
        $image = $_POST['image']; // Gérer l'upload si besoin
        $categorieid = ($_POST['categorieid']);

        $stmt = $pdo->prepare("UPDATE livre SET titre=?, auteur=?, annee_publication=?, description=?, prix=?, stock=?, image=?, categorie_id=? WHERE id=?");
        $stmt->execute([$titre, $auteur, $annee, $description, $prix, $stock, $image, $categorieid, $livre_id]);

        header('Location: index.php?page=admin_livres');
        exit();
    }

    // Récupérer les infos du livre et la liste des catégories pour le formulaire
    $stmt = $pdo->prepare("SELECT * FROM livre WHERE id = ?");
    $stmt->execute([$livre_id]);
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);

    // Afficher la vue de modification
    require 'Vue/admin/edit-livre.php';
}

}

