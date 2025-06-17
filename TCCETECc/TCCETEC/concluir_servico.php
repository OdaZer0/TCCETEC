<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$autonomoId = $_SESSION['usuario_id'];
$servicoId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$pdo = Conexao::getConexao();

$stmt = $pdo->prepare("SELECT * FROM SolicitacoesServico WHERE Id = :id AND IdAutonomo = :autonomoId AND Status = 'aceito'");
$stmt->execute([':id' => $servicoId, ':autonomoId' => $autonomoId]);
$servico = $stmt->fetch();

if ($servico) {
    $dataSolicitada = $servico['DataSolicitada'];
    
    // DEBUG
    // echo "Data atual servidor: " . date('Y-m-d') . "<br>";
    // echo "Data do serviço: " . date('Y-m-d', strtotime($dataSolicitada)) . "<br>";
    
    if (date('Y-m-d') == date('Y-m-d', strtotime($dataSolicitada))) {
        $stmt = $pdo->prepare("UPDATE ServicoAutonomo SET Status = 'concluído', MesConclusao = :mes, AnoConclusao = :ano WHERE Id = :id");
        $stmt->execute([
            ':mes' => date('m'),
            ':ano' => date('Y'),
            ':id' => $servico['IdServico']
        ]);

        $stmt = $pdo->prepare("UPDATE SolicitacoesServico SET Status = 'concluído' WHERE Id = :id");
        $stmt->execute([':id' => $servicoId]);

        header("Location: Tela_autonomo.php");
        exit();
    } else {
        echo "Você só pode marcar como concluído no dia do serviço.";
    }
} else {
    echo "Serviço não encontrado ou não aceito.";
}
