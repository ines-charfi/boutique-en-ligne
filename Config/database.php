<?php
class Database {
    private $host = "localhost";
    private $db_name = "boutique_en_ligne";
    private $username = "root";
    private $password = "";
    public $conn;
    
    /**
     * Établit la connexion à la base de données
     * @return PDO Objet PDO représentant la connexion à la base de données
     */
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Erreur de connexion: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>