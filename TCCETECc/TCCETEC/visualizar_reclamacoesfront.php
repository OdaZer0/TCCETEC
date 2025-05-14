<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'ADM') {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();

// Busca as reclamações da mais ANTIGA para a mais NOVA
$query = $pdo->query("SELECT * FROM ReclamaoDenuncia ORDER BY Data ASC");
$reclamacoes = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Reclamações e Denúncias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f4f8;
            font-family: 'Arial', sans-serif;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .card-title {
            font-weight: bold;
        }
        .badge-warning {
            background-color: orange;
        }
        .badge-success {
            background-color: green;
        }
        .grid-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
        }
        .grid-item {
            flex: 0 1 calc(33.333% - 20px); /* 3 colunas */
        }
        @media (max-width: 768px) {
            .grid-item {
                flex: 0 1 calc(50% - 20px); /* 2 colunas em telas médias */
            }
        }
        @media (max-width: 480px) {
            .grid-item {
                flex: 0 1 100%; /* 1 coluna em telas pequenas */
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Reclamações e Denúncias</h2>

    <div class="grid-container">
        <?php if (count($reclamacoes) === 0): ?>
            <p class="text-center">Nenhuma reclamação encontrada.</p>
        <?php else: ?>
            <?php foreach ($reclamacoes as $rec): ?>
                <div class="grid-item">
                    <div class="card p-3">
                        <h5 class="card-title"><?= htmlspecialchars($rec['Tipo']) ?></h5>
                        <p class="card-text"><strong>Descrição:</strong><br><?= nl2br(htmlspecialchars($rec['Descricao'])) ?></p>
                        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($rec['Data'])) ?></p>
                        <p><strong>Quem Reclamou (CR):</strong> <?= $rec['CR_QuemReclamou'] ?></p>
                        <p><strong>Acusado (CR):</strong> <?= $rec['CR_Acusado'] ?? '-' ?></p>
                        <p><strong>Status:</strong>
                            <span class="badge <?= $rec['Status'] === 'Resolvido' ? 'badge-success' : 'badge-warning' ?>">
                                <?= $rec['Status'] ?>
                            </span>
                        </p>

                        <?php if ($rec['Status'] === 'Pendente'): ?>
                            <form method="POST" action="marcar_resolvido.php">
                                <input type="hidden" name="id" value="<?= $rec['Id'] ?>">
                                <button class="btn btn-sm btn-outline-success w-100">Fechar Denúncia</button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-sm btn-secondary w-100" disabled>Já Resolvida</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
