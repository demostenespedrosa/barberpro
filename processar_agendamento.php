<?php
session_start();
require_once 'conexao.php';

// Verifica se o cliente está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit();
}

// Verifica se os dados foram recebidos
if (!isset($_POST['cliente_id'], $_POST['data'], $_POST['servico_id'], $_POST['horario'])) {
    echo "Erro: Dados incompletos.";
    exit();
}

// Pega os dados do formulário
$cliente_id = $_POST['cliente_id'];
$data = $_POST['data'];
$servico_id = $_POST['servico_id'];
$horario = $_POST['horario'];

// Insere o agendamento no banco
$sql = "INSERT INTO agendamentos (cliente_id, servico_id, data, horario) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $cliente_id, $servico_id, $data, $horario);

if ($stmt->execute()) {
    header("Location: dashboard_cliente.php?sucesso=1");
    exit();
} else {
    echo "Erro ao agendar: " . $stmt->error;
}
?>
