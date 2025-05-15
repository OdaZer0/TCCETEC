<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Usuário</title>

    <!-- Link para o Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 para alertas bonitos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- AOS para animações -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Estilos Customizados -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            font-size: 16px;
            line-height: 1.6;
            padding: 20px;
        }

        /* Navbar */
        .navbar {
            background-color: #1a73e8;
            padding: 15px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
        }

        .navbar-nav .nav-link {
            color: white;
            font-weight: 600;
            padding: 12px 20px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #1558b1;
            border-radius: 5px;
        }

        /* Sidebar */
        .sidebar {
            background-color: #1a73e8;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 30px 20px;
            width: 280px;
            transition: width 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 1.6rem;
            text-align: center;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
            display: block;
            transition: background-color 0.2s ease;
        }

        .sidebar ul li a:hover {
            background-color: #1558b1;
            border-radius: 5px;
            padding: 10px;
        }

        /* Conteúdo Principal */
        .main-content {
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #333;
        }

        .header p {
            font-size: 1.3rem;
            color: #555;
        }

        /* Cards */
        .card-custom {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #1a73e8;
            color: white;
            font-size: 1.6rem;
            padding: 25px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            padding: 25px;
        }

        .card-body p {
            font-size: 1rem;
            color: #555;
        }

        .card-body a {
            font-size: 1.1rem;
            color: #1a73e8;
            text-decoration: none;
        }

        .card-body a:hover {
            text-decoration: underline;
        }

        /* Botões */
        .btn-action {
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            border-radius: 25px;
            font-size: 1.2rem;
            border: none;
            width: 100%;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-action:hover {
            background-color: #218838;
        }

        /* Gráficos */
        .charts-container {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
        }

        /* Modo claro/escuro */
        .dark-mode {
            background-color: #333;
            color: #fff;
        }

        .dark-mode .navbar {
            background-color: #222;
        }

        .dark-mode .sidebar {
            background-color: #222;
        }

        .dark-mode .card-custom {
            background-color: #444;
            color: white;
        }

        /* Rodapé */
        .footer {
            background-color: #1a73e8;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            font-size: 1rem;
        }

        /* Animação de fade-in */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="PerfilUser.php">Perfil</a></li>
            <li><a href="MinhasContratacoes.php">Ver Serviços</a></li>
            <li><a href="">Minha Agenda</a></li>
            <li><a href="form_denuncia.php">Denúncia</a></li>
        </ul>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <div class="header fade-in">
            <h1>Bem-vindo, Usuário!</h1>
            <p>Selecione uma das opções no menu lateral para começar.</p>
        </div>

        <!-- Gráficos e Estatísticas -->
        <div class="charts-container">
            <!-- Gráfico de Pizza de Avaliação -->
            <div class="card card-custom col-md-4">
                <div class="card-header">Avaliações (1 a 5 estrelas)</div>
                <div class="card-body">
                    <canvas id="pizzaChart"></canvas>
                </div>
            </div>

            <!-- Gráfico de Linhas (desempenho) -->
            <div class="card card-custom col-md-4">
                <div class="card-header">Desempenho ao longo do tempo</div>
                <div class="card-body">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <!-- Gráfico de Barras -->
            <div class="card card-custom col-md-4">
                <div class="card-header">Comparação de Serviços</div>
                <div class="card-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <<?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Inicialização das animações
        AOS.init();

        // Gráfico de Pizza
        var ctx1 = document.getElementById('pizzaChart').getContext('2d');
        var pizzaChart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['1 Estrela', '2 Estrelas', '3 Estrelas', '4 Estrelas', '5 Estrelas'],
                datasets: [{
                    data: [15, 25, 35, 45, 100],
                    backgroundColor: ['#ff3d00', '#ff9100', '#ffeb3b', '#4caf50', '#2196f3'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            }
        });

        // Gráfico de Linha
        var ctx2 = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Desempenho',
                    data: [0, 20, 50, 75, 90, 100, 110],
                    fill: false,
                    borderColor: '#28a745',
                    tension: 0.1
                }]
            }
        });

        // Gráfico de Barras
        var ctx3 = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['Serviço A', 'Serviço B', 'Serviço C', 'Serviço D'],
                datasets: [{
                    label: 'Comparação',
                    data: [12, 15, 10, 20],
                    backgroundColor: ['#2196f3', '#ffeb3b', '#4caf50', '#ff3d00']
                }]
            }
        });

        // Alternar Modo Escuro
        document.getElementById('toggleMode').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
        });
    </script>
</body>

</html>
