<?php
require 'Conexao.php';
$conexao = Conexao::getConexao();

// Consulta para pegar as avaliações
$queryAvaliacoes = $conexao->prepare("
    SELECT 
        AutonomoId, 
        SUM(CASE WHEN Estrela = 1 THEN 1 ELSE 0 END) AS estrela_1,
        SUM(CASE WHEN Estrela = 2 THEN 1 ELSE 0 END) AS estrela_2,
        SUM(CASE WHEN Estrela = 3 THEN 1 ELSE 0 END) AS estrela_3,
        SUM(CASE WHEN Estrela = 4 THEN 1 ELSE 0 END) AS estrela_4,
        SUM(CASE WHEN Estrela = 5 THEN 1 ELSE 0 END) AS estrela_5
    FROM Avaliacao
    GROUP BY AutonomoId
");
$queryAvaliacoes->execute();
$avaliacoes = $queryAvaliacoes->fetchAll();

// Consulta para pegar o total de serviços por mês
$queryServicosPorMes = $conexao->prepare("
    SELECT 
        YEAR(DataCadastro) AS ano,
        MONTH(DataCadastro) AS mes,
        COUNT(Id) AS total_servicos
    FROM ServicoAutonomo
    GROUP BY YEAR(DataCadastro), MONTH(DataCadastro)
    ORDER BY ano DESC, mes DESC
");
$queryServicosPorMes->execute();
$servicosPorMes = $queryServicosPorMes->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Autônomo</title>

    <!-- Link para o Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link para a fonte Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <!-- Link para o Chart.js (para gráficos) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Reset de Margens e Paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f7fb;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Estilizada */
        .navbar {
            background-color: #007bff;
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-weight: 600;
        }

        .navbar a:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }

        .navbar .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }

        /* Sidebar */
        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 50px;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 12px 20px;
            display: block;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #007bff;
            border-radius: 5px;
        }

        /* Conteúdo Principal */
        .container {
            margin-left: 260px;
            margin-top: 50px;
            flex-grow: 1;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .card-custom {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-10px);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            padding: 20px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            font-size: 1rem;
            color: #555;
        }

        .card-body a {
            font-size: 1.1rem;
            color: #007bff;
            text-decoration: none;
        }

        .card-body a:hover {
            text-decoration: underline;
        }

        .footer {
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 1rem;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            font-size: 1rem;
        }

        .btn-action {
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            border-radius: 25px;
            font-size: 1.1rem;
            border: none;
            width: 100%;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-action:hover {
            background-color: #218838;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer .btn-secondary {
            background-color: #007bff;
        }

        .sidebar-heading {
            font-size: 1.2rem;
            font-weight: 700;
            padding: 10px 20px;
        }

        .chart-container {
            width: 100%;
            height: 400px;
        }

        .btn-outline-info {
            margin-top: 15px;
        }

        .notification-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: red;
            color: white;
            font-size: 0.75rem;
            border-radius: 50%;
            padding: 5px 10px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                margin-left: 0;
                margin-top: 50px;
            }
            .sidebar {
                position: relative;
                height: auto;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="sidebar-heading">Painel de Controle</h3>
        <a href="PerfilAutonomo.php">Meu Perfil</a>
        <a href="MeusServicos.php">Meus Serviços</a>
        <a href="SolicitacoesAutonomo.php">Solicitações</a>
        <a href="AgendaAutonomo.php">Agenda</a>
        <a href="reclamacao_tela.php">Denúncia</a>
        <a href="ConfiguraçõesAutonomo.php">Configurações</a>
        <a href="logout.php">Sair</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">Autônomo App</a>
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#notificationModal">Notificações <span class="notification-badge">5</span></button>
            </div>
        </nav>

        <h1>Bem-vindo de volta, Autônomo!</h1>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header">
                        Desempenho de Serviços
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header">
                        Avaliações (1 a 5 Estrelas)
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="ratingsChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p><strong>Avaliação Total:</strong> <span id="totalRating">4.2</span> / 5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Solicitações -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        Tabela de Solicitações
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Serviço 1</td>
                                    <td>Cliente A</td>
                                    <td>15/05/2025</td>
                                    <td><span class="badge bg-success">Confirmado</span></td>
                                    <td><button class="btn btn-primary btn-sm">Ver Detalhes</button></td>
                                </tr>
                                <tr>
                                    <td>Serviço 2</td>
                                    <td>Cliente B</td>
                                    <td>16/05/2025</td>
                                    <td><span class="badge bg-warning">Pendente</span></td>
                                    <td><button class="btn btn-primary btn-sm">Ver Detalhes</button></td>
                                </tr>
                                <tr>
                                    <td>Serviço 3</td>
                                    <td>Cliente C</td>
                                    <td>17/05/2025</td>
                                    <td><span class="badge bg-danger">Cancelado</span></td>
                                    <td><button class="btn btn-primary btn-sm">Ver Detalhes</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="row">
            <div class="col-md-6">
                <button class="btn-action">Criar Novo Serviço</button>
            </div>
            <div class="col-md-6">
                <button class="btn-action" onclick="window.location.href='MeusServicos.php'">Ver Solicitações</button>
            </div>
        </div>

        <!-- Modal de Notificações -->
        <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">Notificações</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem 5 novas notificações.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script do Chart.js -->
    <script>
        var ctxPerformance = document.getElementById('performanceChart').getContext('2d');
        var ctxRatings = document.getElementById('ratingsChart').getContext('2d');

        // Gráfico de Desempenho de Serviços (por mês)
        var performanceChart = new Chart(ctxPerformance, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_map(function($row) { return $row['ano'] . '-' . $row['mes']; }, $servicosPorMes)); ?>,
                datasets: [{
                    label: 'Serviços Realizados',
                    data: <?php echo json_encode(array_map(function($row) { return $row['total_servicos']; }, $servicosPorMes)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1,
                    barThickness: 25
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Mês-Ano'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total de Serviços'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Avaliações (Gráfico de Pizza)
        const ratingsChart = new Chart(ctxRatings, {
            type: 'pie',
            data: {
                labels: ['1 estrela', '2 estrelas', '3 estrelas', '4 estrelas', '5 estrelas'],
                datasets: [{
                    data: <?php echo json_encode(array(
                        $avaliacoes[0]['estrela_1'], 
                        $avaliacoes[0]['estrela_2'], 
                        $avaliacoes[0]['estrela_3'], 
                        $avaliacoes[0]['estrela_4'], 
                        $avaliacoes[0]['estrela_5']
                    )); ?>,
                    backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)', 'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)'],
                    borderColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>

