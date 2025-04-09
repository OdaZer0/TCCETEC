<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];

$pdo = Conexao::getConexao();
$stmt = $pdo->prepare("
    SELECT ss.*, sa.Titulo, a.Nome AS NomeAutonomo
    FROM SolicitacoesServico ss
    JOIN ServicoAutonomo sa ON ss.IdServico = sa.Id
    JOIN Autonomo a ON sa.IdAutonomo = a.Id
    WHERE ss.IdUsuario = :id
");
$stmt->execute([':id' => $usuarioId]);
$contratacoes = $stmt->fetchAll();
?>

<h3>Minhas Contratações</h3>

<?php foreach ($contratacoes as $c): ?>
    <div>
        <strong><?= $c['Titulo'] ?> (<?= $c['NomeAutonomo'] ?>)</strong><br>
        Data: <?= $c['DataSolicitada'] ?> | Status: <?= ucfirst($c['Status']) ?>
    </div><hr>
<?php endforeach; ?>
