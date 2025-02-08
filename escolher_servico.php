<?php
session_start();
include 'conexao.php';

if (!isset($_GET['estabelecimento']) || !isset($_GET['data'])) {
    echo "Dados inválidos!";
    exit();
}

$estabelecimento_id = $_GET['estabelecimento'];
$data_escolhida = $_GET['data'];
$dia_semana = strtolower(date('l', strtotime($data_escolhida))); // Obtém o dia da semana

// Verifica se o estabelecimento abre nesse dia
$sql = "SELECT * FROM horarios_funcionamento WHERE usuario_id = ? AND dia_semana = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $estabelecimento_id, $dia_semana);
$stmt->execute();
$horario = $stmt->get_result()->fetch_assoc();

if (!$horario) {
    echo "O estabelecimento não atende nesta data!";
    exit();
}

// Buscar serviços do estabelecimento
$sql = "SELECT * FROM servicos WHERE estabelecimento_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $estabelecimento_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolher Serviço</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Escolha um serviço</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <a href="escolher_horario.php?estabelecimento=<?= $estabelecimento_id ?>&data=<?= $data_escolhida ?>&servico=<?= $row['id'] ?>">
                    <?= $row['nome'] ?> - R$<?= number_format($row['valor'], 2, ',', '.') ?> (<?= $row['duracao'] ?> min)
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
