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
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.4/css/all.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7fc;
            font-family: 'Poppins', sans-serif;
        }
        .card-compromisso {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-compromisso:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #5f6368;
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 12px 16px;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .card-body {
            padding: 20px;
        }
        .card-body p {
            font-size: 0.95rem;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .alert-info {
            background-color: #eaf2f8;
            color: #2188b6;
        }
        .container {
            margin-top: 50px;
        }
        .row {
            margin-top: 30px;
        }
        .fw-bold {
            font-weight: 700;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #5f6368;
            color: white;
        }
        .modal-footer .btn {
            border-radius: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center fw-bold text-dark mb-5">Meus Compromissos</h2>

    <?php if (empty($servicos)): ?>
        <div class="alert alert-info text-center" role="alert">
            Você ainda não aceitou nenhum serviço.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($servicos as $servico): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-compromisso">
                        <div class="card-header">
                            <i class="fas fa-calendar-check"></i> <?= htmlspecialchars($servico['Titulo']) ?>
                        </div>
                        <div class="card-body">
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($servico['Tipo']) ?></p>
                            <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($servico['DataSolicitada'])) ?></p>
                            <p><strong>Contratante:</strong> <?= htmlspecialchars($servico['NomeUsuario']) ?></p>
                            <p><strong>CR do Usuário:</strong> <?= htmlspecialchars($servico['CR']) ?></p>
                            <div class="d-flex justify-content-between">
                                <!-- Botão Cancelar -->
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#cancelarModal<?= $servico['Id'] ?>"><i class="fas fa-ban"></i> Cancelar</button>

                                <!-- Botão Concluído (só habilitado no dia do serviço) -->
                                <?php if (date('Y-m-d') == date('Y-m-d', strtotime($servico['DataSolicitada']))): ?>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#concluirModal<?= $servico['Id'] ?>"><i class="fas fa-check"></i> Concluído</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled><i class="fas fa-check"></i> Concluído</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Cancelar -->
                <div class="modal fade" id="cancelarModal<?= $servico['Id'] ?>" tabindex="-1" aria-labelledby="cancelarModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelarModalLabel">Cancelar Compromisso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <form action="cancelar_servico.php" method="POST">
                                <div class="modal-body">
                                    <p>Você tem certeza que deseja cancelar este compromisso?</p>
                                    <input type="hidden" name="id" value="<?= $servico['Id'] ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Concluir -->
                <div class="modal fade" id="concluirModal<?= $servico['Id'] ?>" tabindex="-1" aria-labelledby="concluirModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="concluirModalLabel">Concluir Compromisso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <form action="concluir_servico.php" method="POST">
                                <div class="modal-body">
                                    <p>Você tem certeza que deseja concluir este compromisso?</p>
                                    <input type="hidden" name="id" value="<?= $servico['Id'] ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Concluir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center mt-5">
        <a href="tela_autonomo.php" class="btn btn-primary">Voltar</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
