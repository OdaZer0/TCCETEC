<?php
require 'conexao.php';
session_start();

$pdo = Conexao::getConexao();
$stmt = $pdo->query("SELECT s.*, a.Nome AS NomeAutonomo FROM ServicoAutonomo s JOIN Autonomo a ON s.IdAutonomo = a.Id ORDER BY RAND()");
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Serviços Disponíveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .servico-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
            background-color: #ffffff;
        }
        .servico-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .card-body label {
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="text-center fw-bold mb-5">Serviços Disponíveis</h2>

    <div class="row g-4">
        <?php foreach ($servicos as $servico): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card servico-card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><?= htmlspecialchars($servico['Titulo']) ?></h5>
                            <h6 class="text-muted mb-2">por <?= htmlspecialchars($servico['NomeAutonomo']) ?></h6>
                            <p class="card-text"><?= htmlspecialchars($servico['Descricao']) ?></p>
                            <p><strong>Tipo:</strong> <?= $servico['Tipo'] ?><br>
                               <strong>Valor:</strong> R$<?= number_format($servico['Valor'], 2, ',', '.') ?></p>
                        </div>

                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <form method="post" action="solicitar_servico.php" class="mt-3">
                                <input type="hidden" name="id_servico" value="<?= $servico['Id'] ?>">
                                <input type="hidden" name="id_autonomo" value="<?= $servico['IdAutonomo'] ?>">
                                <div class="mb-2">
                                    <label for="data_solicitada" class="form-label">Data desejada:</label>
                                    <input type="date" name="data_solicitada" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Contratar</button>
                            </form>
                        <?php else: ?>
                            <p class="mt-3 text-muted text-center"><em>Faça login como usuário para contratar</em></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <a href="Tela_Inicio.html" class="btn btn-primary btn-lg rounded-pill">Voltar</a>
    </div>
</div>
</body>
</html>
