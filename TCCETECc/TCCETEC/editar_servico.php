<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $data = $_POST['data'];

    $pdo = Conexao::getConexao();
    $stmt = $pdo->prepare("UPDATE SolicitacoesServico SET Titulo = :titulo, DataSolicitada = :data WHERE Id = :id");
    $stmt->execute([':titulo' => $titulo, ':data' => $data, ':id' => $id]);

    header("Location: agenda.php");
    exit();
}
?>
