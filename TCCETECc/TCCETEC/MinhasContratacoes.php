<?php
session_start();
require 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$pdo = Conexao::getConexao();
$idAutonomo = $_SESSION['usuario_id'];

// Obtendo as solicitações pendentes
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f7f9fc;
        }

        .solicitacao-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .solicitacao-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            color: #343a40;
        }

        .solicitacao-card p {
            font-size: 0.95rem;
            color: #6c757d;
        }

        .solicitacao-card small {
            font-size: 0.85rem;
            color: #28a745;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 0.875rem;
        }

        .alert-info {
            font-size: 1.1rem;
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        .btn-success, .btn-danger {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4 text-center">Solicitações Pendentes</h2>

    <?php if (empty($solicitacoes)): ?>
        <div class="alert alert-info text-center">Nenhuma solicitação pendente no momento.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($solicitacoes as $sol): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card solicitacao-card p-4 h-100">
                        <h5 class="card-title"><?= htmlspecialchars($sol['Titulo']) ?></h5>
                        <p>
                            <strong>Data:</strong> <?= date('d/m/Y', strtotime($sol['DataSolicitada'])) ?><br>
                            <strong>Usuário:</strong> <?= htmlspecialchars($sol['Nome']) ?><br>
                            <strong>CR:</strong> <?= htmlspecialchars($sol['CR']) ?>
                        </p>
                        <div class="mt-auto d-flex justify-content-between">
                            <!-- Botões de Aceitar e Recusar -->
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAceitarRecusar" data-id="<?= $sol['Id'] ?>" data-acao="aceitar">Aceitar</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalAceitarRecusar" data-id="<?= $sol['Id'] ?>" data-acao="recusar">Recusar</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="modalAceitarRecusar" tabindex="-1" aria-labelledby="modalAceitarRecusarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAceitarRecusarLabel">Confirmação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja <span id="acaoModal"></span> esta solicitação?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="btnModalConfirmar" class="btn">Confirmar</a>
            </div>
        </div>
    </div>
</div>

<!-- Botão de Voltar -->
<a href="Tela_autonomo.html" class="btn btn-secondary mt-3">Voltar</a>

<script>
    // Script para modificar o modal com base na ação (aceitar ou recusar)
    var modal = document.getElementById('modalAceitarRecusar');
    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var acao = button.getAttribute('data-acao');
        var id = button.getAttribute('data-id');
        
        // Alterando a ação no modal
        var acaoText = acao === 'aceitar' ? 'aceitar' : 'recusar';
        document.getElementById('acaoModal').textContent = acaoText;
        
        // Definindo o link do botão de confirmação
        var btnConfirmar = document.getElementById('btnModalConfirmar');
        btnConfirmar.href = 'responder_solicitacao.php?id=' + id + '&acao=' + acao;
    });
</script>

</body>
</html>
