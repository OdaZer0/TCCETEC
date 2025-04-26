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
    <title>Solicitações Pendentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .solicitacao-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            background-color: #ffffff;
            transition: transform 0.2s;
        }
        .solicitacao-card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">Solicitações Pendentes</h2>

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
                            <a href="responder_solicitacao.php?id=<?= $sol['Id'] ?>&acao=aceitar" class="btn btn-success btn-sm">Aceitar</a>
                            <a href="responder_solicitacao.php?id=<?= $sol['Id'] ?>&acao=recusar" class="btn btn-danger btn-sm">Recusar</a>
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
