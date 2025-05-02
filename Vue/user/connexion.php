<?php require_once  'Vue/Bases/header.php'; ?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Connexion</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($erreur)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($erreur); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="index.php?action=traiter_connexion" method="post">
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Vous n'avez pas de compte ? <a href="index.php?action=inscription">Inscrivez-vous ici</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once  'Vue/Bases/footer.php'; ?>