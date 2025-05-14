<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'ADM') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $pdo = Conexao::getConexao();
    $id = intval($_POST['id']);

    $stmt = $pdo->prepare("UPDATE ReclamaoDenuncia SET Status = 'Resolvido' WHERE Id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header("Location: visualizar_reclamacoesfront.php");
exit();
