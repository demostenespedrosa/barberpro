<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estabelecimento') {
    echo "<script>alert('Acesso negado!'); window.location.href='login.html';</script>";
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID inválido!'); window.location.href='dashboard_servicos.html';</script>";
    exit();
}

$usuario_id = $_SESSION['id'];
$servico_id = $_GET['id'];

$sql = "SELECT * FROM servicos WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $servico_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Serviço não encontrado!'); window.location.href='dashboard_servicos.html';</script>";
    exit();
}

$servico = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Editar Serviço</h2>
        <form action="atualizar_servico.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $servico['id']; ?>">
            
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $servico['nome']; ?>" required>

            <label for="valor">Valor (R$):</label>
            <input type="number" name="valor" step="0.01" value="<?php echo $servico['valor']; ?>" required>

            <label for="duracao">Duração (minutos):</label>
            <input type="number" name="duracao" value="<?php echo $servico['duracao']; ?>" required>

            <button type="submit" class="btn">Salvar</button>
        </form>
        <a href="dashboard_servicos.php" class="btn-back">Cancelar</a>
    </div>
</body>
</html>
