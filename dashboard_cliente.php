<?php
require 'verifica_sessao.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard Cliente</title>
</head>
<body>
    <div class="container">
    <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>
    <a class="btn" style="border: none; margin-bottom: 30px;" href="escolher_data.php">Agendar</a> <br/>
    <a href="logout.php">Sair</a>
    </div>

    
</body>
</html>
