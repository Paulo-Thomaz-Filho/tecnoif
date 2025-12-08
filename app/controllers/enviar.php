<?php
require_once '../app/models/Mensagem.php';

class EnviarController {

    public function enviar() {
        header('Content-Type: application/json');

        // 1. Recebe os dados JSON do JavaScript
        $data = json_decode(file_get_contents("php://input"), true);

        // Verifica se o JSON é válido
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["success" => false, "error" => "Dados inválidos."]);
            exit;
        }

        $nome = $data['nome'] ?? '';
        $cpf = $data['cpf_cnpj'] ?? ''; // O JS envia como cpf_cnpj
        $email = $data['email'] ?? '';
        $mensagemTexto = $data['mensagem'] ?? '';

        // 2. Validação simples
        if (empty($nome) || empty($cpf) || empty($email) || empty($mensagemTexto)) {
            echo json_encode(["success" => false, "error" => "Preencha todos os campos."]);
            exit;
        }

        // 3. Chama o Model para salvar
        $mensagemModel = new Mensagem();

        if ($mensagemModel->salvar($nome, $email, $cpf, $mensagemTexto)) {
            echo json_encode(["success" => true, "message" => "Mensagem enviada com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "error" => "Erro ao salvar no banco de dados."]);
        }
        exit;
    }
}