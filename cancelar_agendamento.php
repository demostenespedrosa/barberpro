<?php
session_start();
require_once 'conexao.php';

// Verifica se o cliente está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: login.html");
    exit();
}

// Verifica se o ID do agendamento foi enviado
if (!isset($_POST['agendamento_id'])) {
    echo "Erro: Nenhum agendamento selecionado.";
    exit();
}

$agendamento_id = $_POST['agendamento_id'];
$cliente_id = $_SESSION['usuario_id'];

// Deleta o agendamento do cliente
$sql = "DELETE FROM agendamentos WHERE id = ? AND cliente_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $agendamento_id, $cliente_id);

if ($stmt->execute()) {
    header("Location: dashboard_cliente.php?sucesso=1");
    exit();
} else {
    echo "Erro ao cancelar o agendamento: " . $stmt->error;
}
?>
