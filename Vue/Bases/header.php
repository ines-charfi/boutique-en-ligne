<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Styles personnalisés -->
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h1 class="mb-0"><a href="index.php" class="text-white text-decoration-none">Ma Boutique</a></h1>
                </div>
                <div class="col-md-4">
                    <form class="d-flex" action="index.php" method="get">
                        <input type="hidden" name="action" value="recherche">
                        <input class="form-control me-2" type="search" name="q" placeholder="Rechercher..." aria-label="Rechercher">
                        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <div class="dropdown me-3">
                        <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']); ?>
                            <?php else: ?>
                                <i class="fas fa-user me-1"></i> Mon compte
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="index.php?action=admin_dashboard">Administration</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="index.php?action=mon_compte">Mon profil</a></li>
                                <li><a class="dropdown-item" href="index.php?action=mes_commandes">Mes commandes</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?action=deconnexion">Déconnexion</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="index.php?action=connexion">Connexion</a></li>
                                <li><a class="dropdown-item" href="index.php?action=inscription">Inscription</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>