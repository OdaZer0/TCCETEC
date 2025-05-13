<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];

$pdo = Conexao::getConexao();

$stmt = $pdo->prepare("
    SELECT ss.*, sa.Titulo, sa.Tipo, a.Nome AS NomeAutonomo
    FROM SolicitacoesServico ss
    JOIN ServicoAutonomo sa ON ss.IdServico = sa.Id
    JOIN Autonomo a ON ss.IdAutonomo = a.Id
    WHERE ss.IdUsuario = :id AND ss.Status = 'aceito'
    ORDER BY ss.DataSolicitada ASC
");
$stmt->execute([':id' => $usuarioId]);
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .card-servico {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-servico:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border-radius: 12px 12px 0 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }

        .card-body h5 {
            font-weight: 600;
            color: #34495e;
            font-size: 1.25rem;
        }

        .card-body p {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 8px;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
            padding: 10px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .alert {
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
        }

        .row {
            margin-top: 30px;
        }

        .col-md-6 {
            display: flex;
            justify-content: center;
        }

        .d-flex.justify-content-center {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Meus Serviços Agendados</h2>

    <?php if (empty($servicos)): ?>
        <div class="alert alert-info" role="alert">
            Você ainda não contratou nenhum serviço aceito.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($servicos as $servico): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-servico p-4 d-flex flex-column">
                        <div class="card-header">
                            <i class="fas fa-calendar-check"></i> Serviço Agendado
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($servico['Titulo']) ?></h5>
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($servico['Tipo']) ?></p>
                            <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($servico['DataSolicitada'])) ?></p>
                            <p><strong>Prestador:</strong> <?= htmlspecialchars($servico['NomeAutonomo']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center mt-4">
        <a href="Tela_Inicio.html" class="btn btn-primary btn-lg">Voltar</a>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
