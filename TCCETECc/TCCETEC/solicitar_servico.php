<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
$idServico = $_POST['id_servico'] ?? null;
$dataSolicitada = $_POST['data_solicitada'] ?? null;

if ($idServico && $dataSolicitada) {
    $pdo = Conexao::getConexao();

    // Consulta para pegar o Id do Autônomo (caso necessário)
    $stmtAutonomo = $pdo->prepare("SELECT IdAutonomo FROM ServicoAutonomo WHERE Id = :idServico");
    $stmtAutonomo->execute([':idServico' => $idServico]);
    $autonomo = $stmtAutonomo->fetch();

    // Inserir solicitação com o IdAutonomo
    $stmt = $pdo->prepare("INSERT INTO SolicitacoesServico (IdServico, IdUsuario, IdAutonomo, DataSolicitada) VALUES (:idServico, :idUsuario, :idAutonomo, :data)");
    $stmt->execute([
        ':idServico' => $idServico,
        ':idUsuario' => $usuarioId,
        ':idAutonomo' => $autonomo['IdAutonomo'], // Aqui estamos usando o IdAutonomo do serviço
        ':data' => $dataSolicitada
    ]);

    echo "Solicitação enviada com sucesso!";
    // Redirecionar para feedback ou painel
} else {
    echo "Dados incompletos.";
}
?>
