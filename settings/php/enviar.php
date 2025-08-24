<?php
header('Content-Type: application/json');
include("../factory/conexao.php");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verifica campos obrigatórios e monta lista dos que faltam
$campos_faltando = [];
if (empty($data['nome'])) $campos_faltando[] = 'nome';
if (empty($data['email'])) $campos_faltando[] = 'email';
if (empty($data['cpf_cnpj'])) $campos_faltando[] = 'cpf_cnpj';
if (empty($data['servicos'])) $campos_faltando[] = 'servicos';
if (empty($data['mensagem'])) $campos_faltando[] = 'mensagem';

if (empty($campos_faltando)) {
    $nome = $data['nome'];
    $email = $data['email'];
    $cpf_cnpj = $data['cpf_cnpj'];
    $servicos = is_array($data['servicos']) ? implode(', ', $data['servicos']) : $data['servicos'];
    $mensagem = $data['mensagem'];

    $sql = "INSERT INTO mensagem (nome, email, cpf_cnpj, servicos, mensagem) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $nome, $email, $cpf_cnpj, $servicos, $mensagem);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Mensagem registrada com sucesso!"]);
        } else {
            error_log("Erro ao executar statement: " . $stmt->error);
            echo json_encode(["success" => false, "error" => "Falha ao registrar a mensagem."]);
        }
        $stmt->close();
    } else {
        error_log("Erro ao preparar statement: " . $conn->error);
        echo json_encode(["success" => false, "error" => "Erro interno na preparação da query."]);
    }
} else {
    echo json_encode([
        "success" => false,
        "error" => "Dados incompletos.",
        "faltando" => $campos_faltando
    ]);
}

$conn->close();
?>