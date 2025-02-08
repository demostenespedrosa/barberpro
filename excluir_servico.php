<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estabelecimento') {
    echo "<script>alert('Acesso negado!'); window.location.href='login.html';</script>";
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID inválido!'); window.location.href='dashboard_servicos.php';</script>";
    exit();
}

$usuario_id = $_SESSION['id'];
$servico_id = $_GET['id'];

// Verifica se o serviço pertence ao estabelecimento logado
$sql = "SELECT * FROM servicos WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $servico_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Serviço não encontrado ou não pertence a você!'); window.location.href='dashboard_servicos.php';</script>";
    exit();
}

// Exclui o serviço
$sql_delete = "DELETE FROM servicos WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $servico_id);

if ($stmt_delete->execute()) {
    echo "<script>alert('Serviço excluído com sucesso!'); window.location.href='dashboard_servicos.php';</script>";
} else {
    echo "<script>alert('Erro ao excluir serviço!'); window.location.href='dashboard_servicos.php';</script>";
}
?>
