<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Você precisa estar logado!'); window.location.href='login.html';</script>";
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID inválido!'); window.location.href='dashboard_horarios.html';</script>";
    exit();
}

$usuario_id = $_SESSION['id'];
$horario_id = $_GET['id'];

$sql = "DELETE FROM horarios_funcionamento WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $horario_id, $usuario_id);
$stmt->execute();

echo "<script>alert('Horário excluído com sucesso!'); window.location.href='dashboard_horarios.php';</script>";
?>
