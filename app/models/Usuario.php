<?php
require_once '../app/database/Database.php';

class Usuario {
    private $conn;
    private $table_name = "admin"; 

    public $id;
    public $nome;
    public $senha;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login($nome, $senha) {
        $query = "SELECT id, nome, senha FROM " . $this->table_name . " WHERE nome = :nome LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        $nome = htmlspecialchars(strip_tags($nome));
        $stmt->bindParam(":nome", $nome);
        
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($senha, $row['senha'])) { 
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                return true;
            }
        }
        return false;
    }
}