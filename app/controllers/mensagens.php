<?php
// app/controllers/MensagemController.php
require_once '../app/models/Mensagem.php';

class MensagemController {

    public function listar() {
        // Verifica se o usuário é admin antes de entregar os dados (Segurança)
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['admin_id'])) {
            http_response_code(401); // Não autorizado
            echo json_encode(["error" => "Acesso negado."]);
            exit;
        }

        $mensagemModel = new Mensagem();
        $mensagens = $mensagemModel->listarTodas();

        // Retorna JSON
        header('Content-Type: application/json');
        echo json_encode($mensagens);
        exit;
    }
}