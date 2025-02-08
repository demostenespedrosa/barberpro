<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe
    $sql = "SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome, $senha_hash, $tipo);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $senha_hash)) {
            // Criar sessão do usuário
            $_SESSION['id'] = $id;
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            $_SESSION['tipo'] = $tipo;

            // Redirecionar com base no tipo de usuário
            if ($tipo == 'cliente') {
                header("Location: dashboard_cliente.php");
            } elseif ($tipo == 'estabelecimento') {
                header("Location: dashboard_estabelecimento.php");
            } elseif ($tipo == 'admin') {
                header("Location: dashboard_admin.php");
            }
            exit();
        } else {
            echo "<script>alert('Senha incorreta!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('E-mail não encontrado!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
