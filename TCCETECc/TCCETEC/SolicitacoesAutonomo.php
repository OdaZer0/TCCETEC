<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$pdo = Conexao::getConexao();
$idAutonomo = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("
    SELECT ss.Id, ss.DataSolicitada, ss.Status, u.Nome, u.CR, sa.Titulo
    FROM SolicitacoesServico ss
    JOIN ServicoAutonomo sa ON ss.IdServico = sa.Id
    JOIN Usuario u ON ss.IdUsuario = u.Id
    WHERE sa.IdAutonomo = :idAutonomo AND ss.Status = 'pendente'
");
$stmt->execute([':idAutonomo' => $idAutonomo]);
$solicitacoes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações Pendentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f8fc;
            font-family: 'Arial', sans-serif;
        }
        .solicitacao-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.2s ease-in-out;
        }
        .solicitacao-card:hover {
            transform: translateY(-5px);
        }
        .btn-aceitar, .btn-recusar {
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 30px;
            width: 48%;
        }
        .btn-aceitar {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .btn-aceitar:hover {
            background-color: #218838;
        }
        .btn-recusar {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .btn-recusar:hover {
            background-color: #c82333;
        }
        .alert-info {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
        }
        .card-body p {
            font-size: 0.9rem;
        }
        .mt-auto {
            margin-top: auto;
        }
        .container {
            max-width: 1100px;
        }
        .btn-voltar {
            background-color: #6c757d;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-voltar:hover {
            background-color: #5a6268;
        }
        @media (max-width: 768px) {
            .solicitacao-card {
                margin-bottom: 20px;
            }
            .btn-aceitar, .btn-recusar {
                font-size: 0.9rem;
                padding: 8px 18px;
            }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4 text-center text-dark">Solicitações Pendentes</h2>

    <?php if (empty($solicitacoes)): ?>
        <div class="alert alert-info text-center">Nenhuma solicitação pendente no momento.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($solicitacoes as $sol): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card solicitacao-card p-3 h-100">
                        <h5 class="card-title"><?= htmlspecialchars($sol['Titulo']) ?></h5>
                        <p class="mb-2">
                            <strong>Data:</strong> <?= date('d/m/Y', strtotime($sol['DataSolicitada'])) ?><br>
                            <strong>Usuário:</strong> <?= htmlspecialchars($sol['Nome']) ?><br>
                            <strong>CR:</strong> <?= htmlspecialchars($sol['CR']) ?>
                        </p>
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="responder_solicitacao.php?id=<?= $sol['Id'] ?>&acao=aceitar" class="btn btn-aceitar">Aceitar</a>
                            <a href="responder_solicitacao.php?id=<?= $sol['Id'] ?>&acao=recusar" class="btn btn-recusar">Recusar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="d-flex justify-content-center mt-3">
    <a href="Tela_autonomo.php" class="btn btn-voltar">Voltar</a>
</div>

</body>
</html>
