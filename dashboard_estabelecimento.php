
<?php
require 'verifica_sessao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Estabelecimento</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background: #f5f5f7;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #ffffff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .menu-item {
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
            transition: background 0.3s;
        }

        .menu-item:hover {
            background: #e5e5ea;
        }

        .content {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        .header {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .btn {
            background: #007aff;
            border: none;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn:hover {
            background: #005ecb;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Nome do Estabelecimento</h2>
        <div class="menu-item">🏠 Dashboard</div>
        <div class="menu-item">📅 Gerenciar Horários</div>
        <div class="menu-item">💇🏻 Gerenciar Serviços</div>
        <div class="menu-item">⚙️ Configurações</div>
        <div class="menu-item">🚪 Sair</div>
    </div>

    <div class="content">
        <div class="header">Dashboard</div>

        <div class="section">
          <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>
          <p>Você está logado como Estabelecimento.</p>
          <a href="logout.php">Sair</a>
        </div>
        
        <div class="section">
            <h3>Gerenciar Horários</h3>
            <p>Defina os horários de funcionamento do seu estabelecimento.</p>
            <button class="btn" onclick="window.location.href='dashboard_horarios.php'">Configurar Horários</button>
        </div>

        <div class="section">
            <h3>Gerenciar Serviços</h3>
            <p>Defina os serviços prestados pelo estabelecimento.</p>
            <button class="btn" onclick="window.location.href='dashboard_servicos.php'">Configurar Serviços</button>
        </div>

        <div class="section">
            <h3>Criar link de vínculo</h3>
            <p>Dá acesso a novos clientes ter acesso a agendar os serviços prestados pelo estabelecimento.</p>
            <button id="gerarLink" class="btn">Gerar Link de Vínculo</button>
            <p id="linkVinculo"></p>
        </div>
    </div>
            <script>
        document.getElementById("gerarLink").addEventListener("click", function() {
            fetch("gerar_link_vinculo.php")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("linkVinculo").innerHTML = `<a href="${data}" target="_blank">${data}</a>`;
                });
        });
        </script>
</body>
</html>