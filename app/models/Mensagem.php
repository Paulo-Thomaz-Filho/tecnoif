<?php
// app/models/Mensagem.php
require_once '../app/database/Database.php';

class Mensagem {
    private $conn;
    private $table_name = "mensagem"; // Confirme se o nome da tabela é singular ou plural no banco

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listarTodas() {
        // Usamos AS para padronizar o retorno em minúsculo para o JavaScript
        $query = "SELECT 
                    Id AS id, 
                    Nome AS nome, 
                    Email AS email, 
                    CpfCnpj AS cpf_cnpj, 
                    Mensagem AS mensagem, 
                    DataEnvio AS data_envio 
                  FROM " . $this->table_name . " 
                  ORDER BY Id DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; // Retorna lista vazia em caso de erro
        }
    }

    public function salvar($nome, $email, $cpf, $mensagem) {
        $query = "INSERT INTO " . $this->table_name . " (Nome, Email, CpfCnpj, Mensagem) VALUES (:nome, :email, :cpf, :mensagem)";

        try {
            $stmt = $this->conn->prepare($query);

            // Limpa os dados por segurança
            $nome = htmlspecialchars(strip_tags($nome));
            $email = htmlspecialchars(strip_tags($email));
            $cpf = htmlspecialchars(strip_tags($cpf));
            $mensagem = htmlspecialchars(strip_tags($mensagem));

            // Vincula os parâmetros
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":cpf", $cpf);
            $stmt->bindParam(":mensagem", $mensagem);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Em produção, registre o erro em um log, não dê echo aqui
            return false;
        }
    }
}