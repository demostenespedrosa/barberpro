<?php
session_start();
require_once 'conexao.php';

// Verifica se o cliente está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit();
}

// Verifica se os dados necessários foram passados
if (!isset($_GET['data'], $_GET['servico_id'], $_GET['horario'])) {
    echo "Erro: Informações de agendamento incompletas.";
    exit();
}

// Obtém os dados da URL
$cliente_id = $_SESSION['usuario_id'];
$data = $_GET['data'];
$servico_id = $_GET['servico_id'];
$horario = $_GET['horario'];

// Busca informações do serviço no banco
$sql = "SELECT s.nome AS servico, s.valor, s.duracao, u.nome AS estabelecimento 
        FROM servicos s 
        INNER JOIN usuarios u ON s.usuario_id = u.id 
        WHERE s.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $servico_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Erro: Serviço não encontrado.";
    exit();
}

$servico = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Agendamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Confirme seu Agendamento</h2>
    
    <div class="card">
        <p><strong>Estabelecimento:</strong> <?= htmlspecialchars($servico['estabelecimento']) ?></p>
        <p><strong>Serviço:</strong> <?= htmlspecialchars($servico['servico']) ?></p>
        <p><strong>Valor:</strong> R$ <?= number_format($servico['valor'], 2, ',', '.') ?></p>
        <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($data)) ?></p>
        <p><strong>Horário:</strong> <?= $horario ?></p>
        <p><strong>Duração:</strong> <?= $servico['duracao'] ?> minutos</p>
    </div>

    <form action="processar_agendamento.php" method="POST">
        <input type="hidden" name="cliente_id" value="<?= $cliente_id ?>">
        <input type="hidden" name="data" value="<?= $data ?>">
        <input type="hidden" name="servico_id" value="<?= $servico_id ?>">
        <input type="hidden" name="horario" value="<?= $horario ?>">
        <button type="submit" class="btn">Confirmar Agendamento</button>
    </form>

    <a href="escolher_horario.php?data=<?= $data ?>&servico_id=<?= $servico_id ?>" class="btn-secondary">Voltar</a>
</div>

</body>
</html>
