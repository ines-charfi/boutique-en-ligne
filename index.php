<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique en ligne</title>
    <link rel="stylesheet" href="assets\css\style.css">
    <script src="assets\js\main.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    
    
<?php

// Inclusion de la base de données
require_once  './config/database.php';
// Inclusion de la classe de base de données
 
session_start();

// Inclusion des modèles
require_once  'model\Livre.php';
require_once 'model\categorie.php';
require_once 'model\User.php';


// Inclusion des contrôleurs
require_once 'controller\AccueilController.php';
require_once 'controller\LivreController.php';
require_once 'controller\UserController.php';



// Récupération de la page demandée
$page = $_GET['page'] ?? 'accueil';

switch ($page) {

    // Accueil et recherche asynchrone
    case 'accueil':
        (new AccueilController())->index();
        break;
    case 'autocomplete':
        (new AccueilController())->autocomplete();
        break;

    // Boutique et filtrage AJAX
    case 'boutique':
        (new LivreController())->boutique();
        break;
    case 'filtrer_livres':
        (new LivreController())->filtrer();
        break;

    // Détail d'un livre
    case 'livre_detail':
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        if ($id) {
            (new LivreController())->detail($id);
        } else {
            http_response_code(404);
            echo "Page non trouvée";
        }
        break;

    // Inscription / Connexion / Déconnexion utilisateur
    case 'inscription':
        (new UserController())->inscription();
        break;
    case 'connexion':
        (new UserController())->connexion();
        break;
    case 'deconnexion':
        (new UserController())->deconnexion();
        break;

    // Profil utilisateur
    case 'profil':
        (new UserController())->profil();
        break;

    // Gestion du panier et commandes
    case 'panier':
        (new CommandeController())->panier();
        break;
    case 'ajouter_panier':
        (new CommandeController())->ajouterPanier();
        break;
    case 'valider_commande':
        (new CommandeController())->validerCommande();
        break;
    case 'historique_commandes':
        (new CommandeController())->historique();
        break;

    // Gestion des avis
    case 'ajouter_avis':
        (new LivreController())->ajouterAvis();
        break;

    // Espace admin (dashboard, gestion livres, catégories, utilisateurs, commandes, avis)
    case 'admin_dashboard':
        (new AdminController())->dashboard();
        break;
    case 'admin_livres':
        (new AdminController())->livres();
        break;
    case 'admin_categories':
        (new AdminController())->categories();
        break;
    case 'admin_utilisateurs':
        (new AdminController())->utilisateurs();
        break;
    case 'admin_commandes':
        (new AdminController())->commandes();
        break;
    case 'admin_avis':
        (new AdminController())->avis();
        break;

    // Ajoute ici d'autres routes spécifiques selon tes besoins

    default:
        http_response_code(404);
        echo "Page non trouvée";
}
?>

</body>

</html>
