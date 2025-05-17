<?php
session_start();
require 'conexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
$crUsuario = isset($_SESSION['cr']) ? $_SESSION['cr'] : ''; // Verificação para evitar erro de CR não definido

$pdo = Conexao::getConexao();

// Buscar serviços do usuário
$stmt = $pdo->prepare("
    SELECT ss.*, sa.Titulo, sa.Tipo, a.Nome AS NomeAutonomo, a.CR AS CRAutonomo
    FROM SolicitacoesServico ss
    JOIN ServicoAutonomo sa ON ss.IdServico = sa.Id
    JOIN Autonomo a ON ss.IdAutonomo = a.Id
    WHERE ss.IdUsuario = :id AND ss.Status IN ('aceito', 'concluído', 'cancelado')
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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fb;
        }
        .container {
            margin-top: 50px;
        }
        .card-servico {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background-color: #fff;
            transition: transform 0.3s ease;
        }
        .card-servico:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border-radius: 12px 12px 0 0;
            font-weight: 600;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Meus Serviços</h2>

    <?php if (empty($servicos)): ?>
        <div class="alert alert-info text-center">Você ainda não possui serviços agendados.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($servicos as $servico): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-servico">
                        <div class="card-header">
                            <i class="fas fa-calendar-check"></i> <?= ucfirst($servico['Status']) ?>
                        </div>
                        <div class="card-body">
                            <h5><?= htmlspecialchars($servico['Titulo']) ?></h5>
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($servico['Tipo']) ?></p>
                            <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($servico['DataSolicitada'])) ?></p>
                            <p><strong>Prestador:</strong> <?= htmlspecialchars($servico['NomeAutonomo']) ?></p>

                            <?php if (in_array($servico['Status'], ['concluído', 'cancelado'])): ?>
                                <div class="d-flex gap-2 mt-3">
                                    <!-- Avaliação -->
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#avaliacaoModal<?= $servico['Id'] ?>">Avaliar</button>
                                    <!-- Reclamação -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reclamacaoModal<?= $servico['Id'] ?>">Reclamar</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Modal Avaliação -->
                <div class="modal fade" id="avaliacaoModal<?= $servico['Id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="salvar_avaliacao.php" method="POST" class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Avaliação do Serviço</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <input type="hidden" name="autonomo_id" value="<?= $servico['IdAutonomo'] ?>">
                                <input type="hidden" name="cliente_id" value="<?= $usuarioId ?>">

                                <div class="stars mb-3">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star fs-3 text-secondary" data-value="<?= $i ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="estrelas" id="estrelas<?= $servico['Id'] ?>" value="0">
                                <textarea name="comentario" class="form-control" placeholder="Comentário..."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="reclamacaoModal<?= $servico['Id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="reclamacao.php" method="POST" class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Reclamar do Serviço</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Tipo da Reclamação -->
                                <div class="mb-3">
                                    <label for="tipoReclamacao" class="form-label">Tipo</label>
                                    <select class="form-select" name="tipo" id="tipoReclamacao">
                                        <option value="Denúncia de Usuário">Denúncia de Usuário</option>
                                        <option value="Denúncia de Autônomo">Denúncia de Autônomo</option>
                                        <option value="Denúncia Geral">Denúncia Geral</option>
                                        <option value="Bug">Bug</option>
                                        <option value="Sugestão">Sugestão</option>
                                        <option value="Reclamação do Sistema">Reclamação do Sistema</option>
                                    </select>
                                </div>

                                <!-- CR do Acusado (Autônomo) -->
                                <div class="mb-3">
                                    <label for="crAcusado" class="form-label">CR do Acusado (opcional)</label>
                                    <input type="number" class="form-control" name="cr_acusado" value="<?= $servico['CRAutonomo'] ?>" id="crAcusado" readonly>
                                </div>

                                <!-- Descrição da Reclamação -->
                                <div class="mb-3">
                                    <label for="descricaoReclamacao" class="form-label">Descrição</label>
                                    <textarea class="form-control" name="descricao" id="descricaoReclamacao" placeholder="Descreva sua reclamação..." required></textarea>
                                </div>

                                <!-- CR do Reclamante (Usuário) -->
                                <?php if (isset($_SESSION['usuario_id'])): ?>
                                    <?php 
                                    // Coleta o CR do usuário diretamente no banco de dados
                                    $userId = $_SESSION['usuario_id'];
                                    $stmt = $pdo->prepare("SELECT CR FROM Usuario WHERE Id = :id LIMIT 1");
                                    $stmt->bindParam(':id', $userId);
                                    $stmt->execute();
                                    $usuario = $stmt->fetch();
                                    ?>
                                    <!-- Agora o CR do usuário está disponível -->
                                    <input type="hidden" name="cr_reclamante" value="<?= $usuario['CR'] ?>">
                                <?php else: ?>
                                    <div class="alert alert-danger">Erro: CR do usuário não encontrado na sessão.</div>
                                <?php endif; ?>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Enviar Reclamação</button>
                            </div>
                        </form>
                    </div>
                </div>



                <script>
                    document.querySelectorAll('#avaliacaoModal<?= $servico['Id'] ?> .star').forEach(star => {
                        star.addEventListener('click', function () {
                            let value = this.getAttribute('data-value');
                            document.getElementById('estrelas<?= $servico['Id'] ?>').value = value;
                            let stars = document.querySelectorAll('#avaliacaoModal<?= $servico['Id'] ?> .star');
                            stars.forEach((s, i) => {
                                s.classList.remove('text-warning');
                                if (i < value) s.classList.add('text-warning');
                            });
                        });
                    });
                </script>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="Tela_Inicio.php" class="btn btn-primary">Voltar</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
