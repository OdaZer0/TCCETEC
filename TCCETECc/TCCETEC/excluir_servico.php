<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $pdo = Conexao::getConexao();
    $stmt = $pdo->prepare("DELETE FROM SolicitacoesServico WHERE Id = :id");
    $stmt->execute([':id' => $id]);

    header("Location: agenda.php");
    exit();
}
?>
