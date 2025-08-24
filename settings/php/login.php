<?php
session_start(); // inicia a sessão
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(E_ALL);
include("../factory/conexao.php");

try {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        echo json_encode(["success" => false, "error" => "JSON inválido ou não enviado."]);
        exit;
    }

    $nome = $data['nome'] ?? '';
    $senha = $data['senha'] ?? '';

    if (empty($nome) || empty($senha)) {
        echo json_encode(["success" => false, "error" => "Usuário e senha são obrigatórios."]);
        exit;
    }

    $sql = "SELECT * FROM admin WHERE nome = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "error" => "Erro na consulta: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            // Cria a sessão
            $_SESSION['logado'] = true;
            $_SESSION['usuario'] = $nome;

            echo json_encode(["success" => true, "message" => "Login bem-sucedido"]);
        } else {
            echo json_encode(["success" => false, "error" => "Senha incorreta."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Usuário não encontrado."]);
    }

    $stmt->close();
    $conn->close();

} catch (Throwable $e) {
    echo json_encode(["success" => false, "error" => "Exceção no servidor: " . $e->getMessage()]);
}
?>
