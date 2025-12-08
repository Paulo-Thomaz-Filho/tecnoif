<?php
// app/controllers/LoginController.php

// Importa o Model que tem a conexão com o banco
require_once '../app/models/Usuario.php';

class LoginController {

    public function logar() {
        // 1. Captura os dados (Seja JSON do JS ou POST normal)
        $data = $this->getInputData();
        
        $nome = $data['nome'] ?? '';
        $senha = $data['senha'] ?? '';

        // 2. Instancia o Model (Aqui dentro a conexão $pdo é criada automaticamente)
        $usuario = new Usuario();

        // 3. Define que a resposta será JSON
        header('Content-Type: application/json');

        // 4. Validação básica
        if (empty($nome) || empty($senha)) {
            echo json_encode(["status" => "error", "message" => "Por favor, preencha nome e senha."]);
            exit;
        }

        // 5. Usa o Model para verificar o login
        if ($usuario->login($nome, $senha)) {
            // Sucesso: Inicia sessão
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['admin_id'] = $usuario->id;
            $_SESSION['admin_nome'] = $usuario->nome;
            
            echo json_encode(["status" => "success", "message" => "Login realizado com sucesso!"]);
        } else {
            // Erro
            echo json_encode(["status" => "error", "message" => "Usuário ou senha inválidos."]);
        }
        exit;
    }

    // Função auxiliar para pegar os dados corretamente (JSON ou POST)
    private function getInputData() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        if ($method === 'POST' || $method === 'PUT') {
            $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
            // Se o JavaScript mandar JSON
            if (stripos($contentType, 'application/json') !== false) {
                $json = file_get_contents("php://input");
                return json_decode($json, true) ?? [];
            }
            // Se for formulário normal
            return $_POST;
        }
        return $_GET;
    }
}