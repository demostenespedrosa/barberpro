<?php
session_start();
include 'conexao.php';

if (!isset($_GET['estabelecimento']) || !isset($_GET['data']) || !isset($_GET['servico'])) {
    echo "Dados inválidos!";
    exit();
}

$estabelecimento_id = $_GET['estabelecimento'];
$data_escolhida = $_GET['data'];
$servico_id = $_GET['servico'];
$dia_semana = strtolower(date('l', strtotime($data_escolhida))); // Obtém o dia da semana

// Buscar horários de funcionamento
$sql = "SELECT * FROM horarios_funcionamento WHERE usuario_id = ? AND dia_semana = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $estabelecimento_id, $dia_semana);
$stmt->execute();
$horario = $stmt->get_result()->fetch_assoc();

if (!$horario) {
    echo "O estabelecimento não atende nesta data!";
    exit();
}

// Buscar duração do serviço
$sql = "SELECT duracao FROM servicos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $servico_id);
$stmt->execute();
$servico = $stmt->get_result()->fetch_assoc();
$duracao_servico = $servico['duracao'];

// Buscar agendamentos existentes para essa data
$sql = "SELECT horario FROM agendamentos WHERE estabelecimento_id = ? AND data = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $estabelecimento_id, $data_escolhida);
$stmt->execute();
$result = $stmt->get_result();
$horarios_ocupados = [];

while ($row = $result->fetch_assoc()) {
    $inicio = strtotime($row['horario']);
    $fim = $inicio + ($duracao_servico * 60);

    while ($inicio < $fim) {
        $horarios_ocupados[] = date('H:i', $inicio);
        $inicio += 600; // 10 minutos
    }
}

// Gerar horários disponíveis
$inicio = strtotime($horario['abertura']);
$fim = strtotime($horario['fechamento']);
$horarios_disponiveis = [];

while ($inicio < $fim) {
    $hora_formatada = date('H:i', $inicio);
    
    if (!in_array($hora_formatada, $horarios_ocupados)) {
        $horarios_disponiveis[] = $hora_formatada;
    }

    $inicio += 600; // Incrementa 10 minutos
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolher Horário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Escolha um horário</h2>
    <div>
        <?php foreach ($horarios_disponiveis as $horario): ?>
            <a href="confirmar_agendamento.php?estabelecimento=<?= $estabelecimento_id ?>&data=<?= $data_escolhida ?>&servico=<?= $servico_id ?>&horario=<?= $horario ?>" class="botao"><?= $horario ?></a>
        <?php endforeach; ?>
    </div>
</body>
</html>
