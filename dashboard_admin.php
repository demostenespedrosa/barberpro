<?php
require 'verifica_sessao.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>
    <p>Você está logado como Administrador.</p>
    <a href="logout.php">Sair</a>
</body>
</html>
