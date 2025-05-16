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

// Verificar o serviço
$stmt = $pdo->prepare("SELECT * FROM SolicitacoesServico WHERE Id = :id AND IdAutonomo = :autonomoId AND Status = 'aceito'");
$stmt->execute([':id' => $servicoId, ':autonomoId' => $autonomoId]);
$servico = $stmt->fetch();

if ($servico) {
    $dataSolicitada = $servico['DataSolicitada'];
    if (date('Y-m-d') == date('Y-m-d', strtotime($dataSolicitada))) {
        // Atualizar o status para concluído e salvar mês e ano
        $stmt = $pdo->prepare("UPDATE ServicoAutonomo SET Status = 'concluído', MesConclusao = :mes, AnoConclusao = :ano WHERE Id = :id");
        $stmt->execute([
            ':mes' => date('m'),
            ':ano' => date('Y'),
            ':id' => $servico['IdServico']
        ]);

        // Atualizar solicitação
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
?>
