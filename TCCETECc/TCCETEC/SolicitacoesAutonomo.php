<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$pdo = Conexao::getConexao();
$idAutonomo = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("
    SELECT ss.Id, ss.DataSolicitada, ss.Status, u.Nome, u.CR, sa.Titulo
    FROM SolicitacoesServico ss
    JOIN ServicoAutonomo sa ON ss.IdServico = sa.Id
    JOIN Usuario u ON ss.IdUsuario = u.Id
    WHERE sa.IdAutonomo = :idAutonomo AND ss.Status = 'pendente'
");
$stmt->execute([':idAutonomo' => $idAutonomo]);
$solicitacoes = $stmt->fetchAll();
?>

<h3>Solicitações Pendentes</h3>

<?php foreach ($solicitacoes as $sol): ?>
    <div>
        <strong><?= $sol['Titulo'] ?></strong><br>
        <span>Data: <?= $sol['DataSolicitada'] ?> | Usuário: <?= $sol['Nome'] ?> (CR: <?= $sol['CR'] ?>)</span><br>
        <a href="responder_solicitacao.php?id=<?= $sol['Id'] ?>&acao=aceitar">Aceitar</a> |
        <a href="responder_solicitacao.php?id=<?= $sol['Id'] ?>&acao=recusar">Recusar</a>
    </div><hr>
<?php endforeach; ?>
