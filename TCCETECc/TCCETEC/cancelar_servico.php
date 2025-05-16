<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$autonomoId = $_SESSION['usuario_id'];
$servicoId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$pdo = Conexao::getConexao();

// Atualizar status para "pendente" ou "cancelado"
$stmt = $pdo->prepare("UPDATE SolicitacoesServico SET Status = 'pendente' WHERE Id = :id AND IdAutonomo = :autonomoId");
$stmt->execute([':id' => $servicoId, ':autonomoId' => $autonomoId]);

header("Location: Tela_autonomo.php");
exit();
?>
