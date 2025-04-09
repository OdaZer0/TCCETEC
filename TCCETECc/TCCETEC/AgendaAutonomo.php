<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$autonomoId = $_SESSION['usuario_id'];

$pdo = Conexao::getConexao();

// Agora a consulta irá funcionar corretamente com a nova chave de relacionamento
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
<html>
<head>
    <meta charset="UTF-8">
    <title>Agenda de Compromissos</title>
</head>
<body>
    <h2>Meus Compromissos</h2>

    <?php if (empty($servicos)): ?>
        <p>Você ainda não aceitou nenhum serviço.</p>
    <?php else: ?>
        <?php foreach ($servicos as $servico): ?>
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">
                <strong>Serviço:</strong> <?= htmlspecialchars($servico['Titulo']) ?><br>
                <strong>Tipo:</strong> <?= htmlspecialchars($servico['Tipo']) ?><br>
                <strong>Data:</strong> <?= date('d/m/Y', strtotime($servico['DataSolicitada'])) ?><br>
                <strong>Contratante:</strong> <?= htmlspecialchars($servico['NomeUsuario']) ?><br>
                <strong>CR do usuário:</strong> <?= $servico['CR'] ?><br>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
