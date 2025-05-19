<?php
class InscriptionModel {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Vérifie si un email existe déjà dans la base de données
     * @param string $email Email à vérifier
     * @return bool true si l'email existe, false sinon
     */
    public function emailExiste($email) {
        try {
            $query = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la vérification de l'email: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Inscrit un nouvel utilisateur
     * @param array $userData Données de l'utilisateur
     * @return bool|int ID de l'utilisateur si inscription réussie, false sinon
     */
    public function inscrireUtilisateur($userData) {
        try {
            $query = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, adresse, code_postal, ville, telephone, date_inscription, role) 
                     VALUES (:nom, :prenom, :email, :mot_de_passe, :adresse, :code_postal, :ville, :telephone, NOW(), 'client')";
            
            $stmt = $this->db->prepare($query);
            
            // Hachage du mot de passe
            $hashedPassword = password_hash($userData['mot_de_passe'], PASSWORD_DEFAULT);
            
        
            $stmt->bindParam(':email', $userData['email']);
            $stmt->bindParam(':mot_de_passe', $hashedPassword);
  
            $stmt->execute();
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'inscription: " . $e->getMessage());
            return false;
        }
    }
}
?>
