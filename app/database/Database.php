<?php
// app/database/Database.php

class Database {
    // Altere para as suas credenciais reais
    private $host = "";
    private $db_name = "talentos_tecnoif"; 
    private $username = "talentos_tecnoif";
    private $password = "9988110958Pl.";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Cria a conexão usando PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            
            // Configura para gerar erro se algo der errado no SQL
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Garante que caracteres especiais funcionem
            $this->conn->exec("set names utf8");
            
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }

        return $this->conn;
    }
}