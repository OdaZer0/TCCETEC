<?php
require 'conexao.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$acao = $_GET['acao'] ?? null;

if ($id <= 0 || !in_array($acao, ['aceitar', 'recusar'])) {
    echo "Parâmetros inválidos. <a href='SolicitacoesAutonomo.php'>Voltar</a>";
    exit;
}

// Define o novo status com base na ação
$novoStatus = $acao === 'aceitar' ? 'aceito' : 'recusado';

try {
    $pdo = Conexao::getConexao();
    $stmt = $pdo->prepare("UPDATE SolicitacoesServico SET Status = :status WHERE Id = :id");
    $stmt->execute([
        ':status' => $novoStatus,
        ':id' => $id
    ]);

    header("Location: SolicitacoesAutonomo.php?msg={$acao}");
    exit;

} catch (PDOException $e) {
    echo "Erro ao atualizar solicitação: " . $e->getMessage();
}
