<?php
session_start();
include 'conexao.php';

// Verifica se o usuário é administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'ADM') {
    die("Acesso restrito a administradores.");
}

if (isset($_POST['reclamacao_id'])) {
    $reclamacao_id = $_POST['reclamacao_id'];

    // Atualiza o status da reclamação para 'Fechado'
    $stmt = $pdo->prepare("UPDATE ReclamaoDenuncia SET Status = 'Fechado' WHERE Id = :id");
    $stmt->bindParam(':id', $reclamacao_id);
    $stmt->execute();

    header("Location: visualizar_reclamacoesfront.php");
    exit();
} else {
    echo "Reclamação não encontrada!";
}
?>
