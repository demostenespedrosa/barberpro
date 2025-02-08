<?php
session_start();
include 'conexao.php';

if (!isset($_GET['estabelecimento'])) {
    echo "Link inválido!";
    exit();
}

$estabelecimento_id = $_GET['estabelecimento'];

if (!isset($_SESSION['id'])) {
    $_SESSION['redirect_after_login'] = "vincular_cliente.php?estabelecimento=$estabelecimento_id";
    header("Location: login.html");
    exit();
}

$cliente_id = $_SESSION['id'];
$tipo = $_SESSION['tipo'];

if ($tipo != 'cliente') {
    echo "<script>alert('Apenas clientes podem se vincular a um estabelecimento!'); window.location.href='dashboard_cliente.php';</script>";
    exit();
}

// Verifica se já está vinculado
$sql_verifica = "SELECT * FROM vinculos WHERE cliente_id = ? AND estabelecimento_id = ?";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("ii", $cliente_id, $estabelecimento_id);
$stmt_verifica->execute();
$result = $stmt_verifica->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Você já está vinculado a este estabelecimento!'); window.location.href='agendamento.php?estabelecimento=$estabelecimento_id';</script>";
    exit();
}

// Insere o vínculo
$sql = "INSERT INTO vinculos (cliente_id, estabelecimento_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cliente_id, $estabelecimento_id);

if ($stmt->execute()) {
    echo "<script>alert('Vínculo realizado com sucesso!'); window.location.href='agendamento.php?estabelecimento=$estabelecimento_id';</script>";
} else {
    echo "<script>alert('Erro ao vincular!'); window.location.href='dashboard_cliente.php';</script>";
}
?>
