<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - NERINAL BOOK</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
<?php include  'Vue\bases\header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Inscription</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($erreur)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($erreur); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="index.php?page=connexion" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($donnees['nom'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($donnees['prenom'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($donnees['email'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="mot_de_passe">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <small class="form-text text-muted">Au moins 8 caractères</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="confirmer_mot_de_passe">Confirmer le mot de passe</label>
                                    <input type="password" class="form-control" id="confirmer_mot_de_passe" name="confirmer_mot_de_passe" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary">S'inscrire</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Vous avez déjà un compte ? <a href="index.php?action=connexion">Connectez-vous ici</a></p>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
<?php include  'Vue\bases\footer.php'; ?>
</html>
