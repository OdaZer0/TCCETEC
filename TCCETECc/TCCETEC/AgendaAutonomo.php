<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$autonomoId = $_SESSION['usuario_id'];

$pdo = Conexao::getConexao();

$stmt = $pdo->prepare("
    SELECT ss.*, sa.Titulo, sa.Tipo, u.Nome AS NomeUsuario, u.CR
    FROM SolicitacoesServico ss
    JOIN ServicoAutonomo sa ON ss.IdServico = sa.Id
    JOIN Usuario u ON ss.IdUsuario = u.Id
    WHERE sa.IdAutonomo = :id AND ss.Status = 'aceito'
    ORDER BY ss.DataSolicitada ASC
");

$stmt->execute([':id' => $autonomoId]);
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Compromissos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
        }
        .card-compromisso {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            background: #ffffff;
        }
        .card-compromisso:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center fw-bold mb-4">Meus Compromissos</h2>

    <?php if (empty($servicos)): ?>
        <div class="alert alert-info text-center" role="alert">
            Você ainda não aceitou nenhum serviço.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($servicos as $servico): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-compromisso p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold"><?= htmlspecialchars($servico['Titulo']) ?></h5>
                            <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($servico['Tipo']) ?></p>
                            <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y', strtotime($servico['DataSolicitada'])) ?></p>
                            <p class="mb-1"><strong>Contratante:</strong> <?= htmlspecialchars($servico['NomeUsuario']) ?></p>
                            <p class="mb-1"><strong>CR do Usuário:</strong> <?= htmlspecialchars($servico['CR']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<a href="Tela_autonomo.html" class="btn btn-secondary mt-3">Voltar</a>

</body>
</html>
