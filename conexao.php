<?php
$host = "localhost";
$usuario = "root"; // Altere se necessário
$senha = ""; // Altere se necessário
$banco = "sistema_login";

// Criar conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
