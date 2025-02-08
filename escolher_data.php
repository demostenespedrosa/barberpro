<?php
session_start();
include 'conexao.php';

if (!isset($_GET['estabelecimento'])) {
    echo "Estabelecimento inválido!";
    exit();
}

$estabelecimento_id = $_GET['estabelecimento'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolher Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Escolha uma data para o atendimento</h2>
    <form action="escolher_servico.php" method="GET">
        <input type="hidden" name="estabelecimento" value="<?= $estabelecimento_id ?>">
        <input type="date" name="data" required>
        <button type="submit" class="btn">Avançar</button>
    </form>
</body>
</html>
