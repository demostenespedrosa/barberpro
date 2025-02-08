<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Você precisa estar logado!'); window.location.href='login.html';</script>";
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID inválido!'); window.location.href='dashboard_horarios.php';</script>";
    exit();
}

$usuario_id = $_SESSION['id'];
$horario_id = $_GET['id'];

$sql = "SELECT * FROM horarios_funcionamento WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $horario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Horário não encontrado!'); window.location.href='dashboard_horarios.html';</script>";
    exit();
}

$horario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Horário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Editar Horário</h2>
        <form action="atualizar_horario.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $horario['id']; ?>">

            <label for="dia">Dia da Semana:</label>
            <select name="dia" required>
                <option value="segunda" <?php if($horario['dia_semana'] == 'segunda') echo 'selected'; ?>>Segunda</option>
                <option value="terca" <?php if($horario['dia_semana'] == 'terca') echo 'selected'; ?>>Terça</option>
                <option value="quarta" <?php if($horario['dia_semana'] == 'quarta') echo 'selected'; ?>>Quarta</option>
                <option value="quinta" <?php if($horario['dia_semana'] == 'quinta') echo 'selected'; ?>>Quinta</option>
                <option value="sexta" <?php if($horario['dia_semana'] == 'sexta') echo 'selected'; ?>>Sexta</option>
                <option value="sabado" <?php if($horario['dia_semana'] == 'sabado') echo 'selected'; ?>>Sábado</option>
                <option value="domingo" <?php if($horario['dia_semana'] == 'domingo') echo 'selected'; ?>>Domingo</option>
            </select>

            <label for="abertura">Horário de Abertura:</label>
            <input type="time" name="abertura" value="<?php echo $horario['abertura']; ?>" required>

            <label for="fechamento">Horário de Fechamento:</label>
            <input type="time" name="fechamento" value="<?php echo $horario['fechamento']; ?>" required>

            <label for="inicio_intervalo">Início do Intervalo (opcional):</label>
            <input type="time" name="inicio_intervalo" value="<?php echo $horario['inicio_intervalo']; ?>">

            <label for="fim_intervalo">Fim do Intervalo (opcional):</label>
            <input type="time" name="fim_intervalo" value="<?php echo $horario['fim_intervalo']; ?>">

            <button type="submit" class="btn">Salvar Alterações</button>
        </form>
        <a href="dashboard_horarios.php" class="btn-back">Cancelar</a>
    </div>
</body>
</html>
