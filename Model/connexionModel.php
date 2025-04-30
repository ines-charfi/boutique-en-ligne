<?php
class ConnexionModel {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Vérifie les identifiants d'un utilisateur
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @return array|bool Données de l'utilisateur si connexion réussie, false sinon
     */
    public function verifierIdentifiants($email, $password) {
        try {
            $query = "SELECT * FROM utilisateurs WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Vérification du mot de passe
                if (password_verify($password, $utilisateur['mot_de_passe'])) {
                    // Ne pas retourner le mot de passe
                    unset($utilisateur['mot_de_passe']);
                    return $utilisateur;
                }
            }
            
            return false;
        } catch (PDOException $e) {
            // Log l'erreur
            error_log("Erreur de connexion: " . $e->getMessage());
            return false;
        }
    }
}
?>