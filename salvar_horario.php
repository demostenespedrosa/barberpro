<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['id'])) {
        echo "<script>alert('Você precisa estar logado!'); window.location.href='login.html';</script>";
        exit();
    }

    $usuario_id = $_SESSION['id'];
    $dias = isset($_POST['dias']) ? $_POST['dias'] : [];
    $hora_abertura = $_POST['hora_abertura'];
    $hora_fechamento = $_POST['hora_fechamento'];
    $inicio_intervalo = !empty($_POST['inicio_intervalo']) ? $_POST['inicio_intervalo'] : null;
    $fim_intervalo = !empty($_POST['fim_intervalo']) ? $_POST['fim_intervalo'] : null;

    if (empty($dias)) {
        echo "<script>alert('Selecione pelo menos um dia da semana!'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO horarios_funcionamento (usuario_id, dia_semana, abertura, fechamento, inicio_intervalo, fim_intervalo) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($dias as $dia) {
        $stmt->bind_param("isssss", $usuario_id, $dia, $hora_abertura, $hora_fechamento, $inicio_intervalo, $fim_intervalo);
        $stmt->execute();
    }

    echo "<script>alert('Horários cadastrados com sucesso!'); window.location.href='dashboard_horarios.html';</script>";
}
?>
