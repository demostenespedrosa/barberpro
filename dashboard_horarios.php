<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Horários</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <h2>Horários de Funcionamento</h2>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Abertura</th>
                    <th>Fechamento</th>
                    <th>Intervalo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                include 'conexao.php';

                if (!isset($_SESSION['id'])) {
                    echo "<tr><td colspan='5'>Você precisa estar logado.</td></tr>";
                    exit();
                }

                $usuario_id = $_SESSION['id'];
                $sql = "SELECT * FROM horarios_funcionamento WHERE usuario_id = ? ORDER BY FIELD(dia_semana, 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ucfirst($row['dia_semana']) . "</td>";
                        echo "<td>" . $row['abertura'] . "</td>";
                        echo "<td>" . $row['fechamento'] . "</td>";
                        echo "<td>" . ($row['inicio_intervalo'] ? $row['inicio_intervalo'] . " - " . $row['fim_intervalo'] : "Sem intervalo") . "</td>";
                        echo "<td>
                                <a href='editar_horario.php?id=" . $row['id'] . "' class='btn-edit'>Editar</a>
                                <a href='excluir_horario.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum horário cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="button-container">
            <a href="cadastro_horario.html" class="btn">Adicionar Novo Horário</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            carregarHorarios();
        });

        function carregarHorarios() {
            $.ajax({
                url: 'listar_horarios.php',
                method: 'GET',
                success: function(response) {
                    $('#horarios-lista').html(response);
                }
            });
        }

        function excluirHorario(id) {
            if (confirm("Tem certeza que deseja excluir este horário?")) {
                $.ajax({
                    url: 'excluir_horario.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        alert(response);
                        carregarHorarios();
                    }
                });
            }
        }
    </script>
</body>
</html>
