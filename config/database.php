<?php
function getPDO() {
    $host = 'localhost';
    $db   = 'boutique'; 
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    return new PDO($dsn, $user, $pass, $options);
}


class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = require './config/database.php';
        try {
            $this->pdo = new PDO(
                "mysql:host={$config['localhost']};dbname={$config['boutique']};charset=utf8",
                $config['root'],
                $config[' password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}

