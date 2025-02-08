<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha
    $tipo = $_POST['tipo'];

    // Verifica se o e-mail já está cadastrado
    $sql_verifica = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("s", $email);
    $stmt_verifica->execute();
    $stmt_verifica->store_result();

    if ($stmt_verifica->num_rows > 0) {
        echo "<script>alert('E-mail já cadastrado!'); window.location.href='cadastro_{$tipo}.html';</script>";
        exit();
    }

    // Inserir no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $senha, $tipo);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Erro no cadastro!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
