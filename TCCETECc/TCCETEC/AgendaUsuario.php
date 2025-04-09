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
<html>
<head>
    <meta charset="UTF-8">
    <title>Minha Agenda</title>
</head>
<body>
    <h2>Serviços Agendados</h2>

    <?php if (empty($servicos)): ?>
        <p>Você ainda não contratou nenhum serviço aceito.</p>
    <?php else: ?>
        <?php foreach ($servicos as $servico): ?>
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">
                <strong>Serviço:</strong> <?= htmlspecialchars($servico['Titulo']) ?><br>
                <strong>Tipo:</strong> <?= htmlspecialchars($servico['Tipo']) ?><br>
                <strong>Data:</strong> <?= date('d/m/Y', strtotime($servico['DataSolicitada'])) ?><br>
                <strong>Prestador:</strong> <?= htmlspecialchars($servico['NomeAutonomo']) ?><br>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
