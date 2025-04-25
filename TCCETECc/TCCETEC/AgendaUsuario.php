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
    <style>
        body {
            background: #f0f2f5;
        }
        .card-servico {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            background: #ffffff;
        }
        .card-servico:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center fw-bold mb-4">Serviços Agendados</h2>

    <?php if (empty($servicos)): ?>
        <div class="alert alert-info text-center" role="alert">
            Você ainda não contratou nenhum serviço aceito.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($servicos as $servico): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-servico p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold"><?= htmlspecialchars($servico['Titulo']) ?></h5>
                            <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($servico['Tipo']) ?></p>
                            <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y', strtotime($servico['DataSolicitada'])) ?></p>
                            <p class="mb-1"><strong>Prestador:</strong> <?= htmlspecialchars($servico['NomeAutonomo']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
