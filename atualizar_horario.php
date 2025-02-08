<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['id'])) {
        echo "<script>alert('Você precisa estar logado!'); window.location.href='login.html';</script>";
        exit();
    }

    $usuario_id = $_SESSION['id'];
    $horario_id = $_POST['id'];
    $dia = $_POST['dia'];
    $abertura = $_POST['abertura'];
    $fechamento = $_POST['fechamento'];
    $inicio_intervalo = !empty($_POST['inicio_intervalo']) ? $_POST['inicio_intervalo'] : null;
    $fim_intervalo = !empty($_POST['fim_intervalo']) ? $_POST['fim_intervalo'] : null;

    $sql = "UPDATE horarios_funcionamento SET dia_semana = ?, abertura = ?, fechamento = ?, inicio_intervalo = ?, fim_intervalo = ? WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $dia, $abertura, $fechamento, $inicio_intervalo, $fim_intervalo, $horario_id, $usuario_id);
    $stmt->execute();

    echo "<script>alert('Horário atualizado com sucesso!'); window.location.href='dashboard_horarios.html';</script>";
}
?>
