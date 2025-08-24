<?php
header('Content-Type: application/json; charset=utf-8');
include("../factory/conexao.php");

$mensagens = [];
$sql = "SELECT nome, email, mensagem FROM mensagem"; // substitua pelo nome da sua tabela
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mensagens[] = [
            "nome" => $row['nome'],
            "email" => $row['email'],
            "mensagem" => $row['mensagem']
        ];
    }
}

echo json_encode($mensagens);
$conn->close();
?>
