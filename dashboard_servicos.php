<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Serviços</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
        <div class="nav-container">
            <h1 class="logo">Meu Estabelecimento</h1>
            <div class="nav-links">
                <a href="dashboard_estabelecimento.php">Dashboard</a>
                <a href="logout.php" class="logout-btn">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Meus Serviços</h2>
        <table>
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Valor (R$)</th>
                    <th>Duração (min)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                include 'conexao.php';

                if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estabelecimento') {
                    echo "<script>alert('Acesso negado!'); window.location.href='login.html';</script>";
                    exit();
                }

                $usuario_id = $_SESSION['id'];
                $sql = "SELECT * FROM servicos WHERE usuario_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nome']}</td>
                            <td>{$row['valor']}</td>
                            <td>{$row['duracao']}</td>
                            <td>
                                <a href='editar_servico.php?id={$row['id']}'>Editar</a> |
                                <a href='excluir_servico.php?id={$row['id']}' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="cadastro_servico.html" class="btn">Adicionar Serviço</a>
        <a href="dashboard_estabelecimento.php" class="btn-back">Voltar</a>
    </div>
</body>
</html>
