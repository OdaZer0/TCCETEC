<?php
require 'conexao.php';
session_start();

$pdo = Conexao::getConexao();
$stmt = $pdo->query("SELECT s.*, a.Nome AS NomeAutonomo FROM ServicoAutonomo s JOIN Autonomo a ON s.IdAutonomo = a.Id ORDER BY RAND()");
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Serviços Disponíveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .servico-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #f7f7f7;
        }
    </style>
</head>
<body class="container">
    <h2 class="my-4">Serviços Disponíveis</h2>

    <?php foreach ($servicos as $servico): ?>
        <div class="servico-card">
            <h4><?= htmlspecialchars($servico['Titulo']) ?> - <?= $servico['NomeAutonomo'] ?></h4>
            <p><?= htmlspecialchars($servico['Descricao']) ?></p>
            <p><strong>Tipo:</strong> <?= $servico['Tipo'] ?> | <strong>Valor:</strong> R$<?= number_format($servico['Valor'], 2, ',', '.') ?></p>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form method="post" action="solicitar_servico.php">
                    <input type="hidden" name="id_servico" value="<?= $servico['Id'] ?>">
                    <input type="hidden" name="id_autonomo" value="<?= $servico['IdAutonomo'] ?>"> <!-- Adicionado IdAutonomo -->
                    <label for="data">Data desejada:</label>
                    <input type="date" name="data_solicitada" required>
                    <button type="submit" class="btn btn-primary">Contratar</button>
                </form>
            <?php else: ?>
                <p><em>Faça login como usuário para contratar</em></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
