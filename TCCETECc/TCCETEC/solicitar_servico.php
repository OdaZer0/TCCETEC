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

$mensagem = "";
$sucesso = false;

if ($idServico && $dataSolicitada) {
    $pdo = Conexao::getConexao();

    // Pega o ID do autônomo vinculado ao serviço
    $stmtAutonomo = $pdo->prepare("SELECT IdAutonomo FROM ServicoAutonomo WHERE Id = :idServico");
    $stmtAutonomo->execute([':idServico' => $idServico]);
    $autonomo = $stmtAutonomo->fetch();

    if ($autonomo) {
        $stmt = $pdo->prepare("INSERT INTO SolicitacoesServico (IdServico, IdUsuario, IdAutonomo, DataSolicitada) VALUES (:idServico, :idUsuario, :idAutonomo, :data)");
        $stmt->execute([
            ':idServico' => $idServico,
            ':idUsuario' => $usuarioId,
            ':idAutonomo' => $autonomo['IdAutonomo'],
            ':data' => $dataSolicitada
        ]);

        $mensagem = "Solicitação enviada com sucesso!";
        $sucesso = true;
    } else {
        $mensagem = "Erro ao localizar o autônomo do serviço.";
    }
} else {
    $mensagem = "Dados incompletos para enviar solicitação.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Solicitação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="max-width: 500px;">
    <h4 class="card-title text-center mb-3"><?= $sucesso ? '✅ Sucesso' : '⚠️ Aviso' ?></h4>
    <div class="alert <?= $sucesso ? 'alert-success' : 'alert-warning' ?>" role="alert">
        <?= htmlspecialchars($mensagem) ?>
    </div>
    <div class="text-center">
        <a href="tela_iniciouser.php" class="btn btn-primary">Voltar à Página Inicial</a>
    </div>
</div>

</body>
</html>
