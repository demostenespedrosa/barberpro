<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estabelecimento') {
    echo "<script>alert('Acesso negado!'); window.location.href='login.html';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['id'];
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $duracao = $_POST['duracao'];

    $sql = "INSERT INTO servicos (usuario_id, nome, valor, duracao) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdi", $usuario_id, $nome, $valor, $duracao);
    
    if ($stmt->execute()) {
        echo "<script>alert('Serviço cadastrado com sucesso!'); window.location.href='dashboard_servicos.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar!'); window.location.href='cadastro_servico.html';</script>";
    }
}
?>
