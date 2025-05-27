<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'ADM') {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();

// Busca todas as reclamações sem ordenar por status
$query = $pdo->query("SELECT * FROM ReclamaoDenuncia ORDER BY Data ASC");
$reclamacoes = $query->fetchAll();

// Separando as reclamações resolvidas das pendentes
$pendentes = [];
$resolvidas = [];

foreach ($reclamacoes as $rec) {
    if ($rec['Status'] === 'Pendente') {
        $pendentes[] = $rec;
    } else {
        $resolvidas[] = $rec;
    }
}

// Concatenando as pendentes primeiro e as resolvidas por último
$reclamacoesOrdenadas = array_merge($pendentes, $resolvidas);
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
                flex: 0 1 calc(50% - 20px); /* 2 colunas */
            }
        }
        @media (max-width: 480px) {
            .grid-item {
                flex: 0 1 100%; /* 1 coluna */
            }
        }
        .copiado-msg {
            display: none;
            padding: 2px 8px;
            font-size: 0.875rem;
            border-radius: 12px;
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
        }

        .copiado-msg.mostrar {
            display: inline-block;
            opacity: 1;
        }

        /* Estilo customizado para as cores */
        .btn-usuario {
            background-color: #d35400;
            color: white;
        }
        .btn-usuario:hover {
            background-color: #e67e22;
        }
        .btn-autonomo {
            background-color: blue;
            color: white;
        }
        .btn-autonomo:hover {
            background-color: #007bff;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<!-- Botões no início -->
<div class="container mt-4 text-center">
    <a href="CrtlADM_User.php" class="btn btn-usuario btn-lg mx-2">
        <i class="bi bi-person"></i> Ir para controle de Usuário
    </a>
    <a href="CtrlADM_Autonomo.php" class="btn btn-autonomo btn-lg mx-2">
        <i class="bi bi-person-fill"></i> Ir para controle de Autônomo
    </a>
    <a href="javascript:history.back()" class="btn btn-secondary btn-lg mx-2">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Reclamações e Denúncias</h2>

    <div class="grid-container">
        <?php if (count($reclamacoesOrdenadas) === 0): ?>
            <p class="text-center">Nenhuma reclamação encontrada.</p>
        <?php else: ?>
            <?php foreach ($reclamacoesOrdenadas as $rec): ?>
                <div class="grid-item">
                    <div class="card p-3">
                        <h5 class="card-title"><?= htmlspecialchars($rec['Tipo']) ?></h5>
                        <p class="card-text"><strong>Descrição:</strong><br><?= nl2br(htmlspecialchars($rec['Descricao'])) ?></p>
                        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($rec['Data'])) ?></p>

                        <!-- Quem Reclamou -->
                        <p>
                            <strong>Quem Reclamou (CR):</strong>
                            <span id="quem-<?= $rec['Id'] ?>"><?= htmlspecialchars($rec['CR_QuemReclamou']) ?></span>
                            <?php if (!empty($rec['CR_QuemReclamou'])): ?>
                                <button class="btn btn-sm btn-outline-primary ms-2" onclick="copiarTexto('quem-<?= $rec['Id'] ?>', 'msg-quem-<?= $rec['Id'] ?>')">Copiar</button>
                                <span id="msg-quem-<?= $rec['Id'] ?>" class="copiado-msg bg-success-subtle text-success ms-2 fw-semibold">
                                    ✔ CR copiado
                                </span>
                            <?php endif; ?>
                        </p>

                        <!-- Acusado -->
                        <p>
                            <strong>Acusado (CR):</strong>
                            <span id="acusado-<?= $rec['Id'] ?>"><?= htmlspecialchars($rec['CR_Acusado'] ?? '-') ?></span>
                            <?php if (!empty($rec['CR_Acusado'])): ?>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copiarTexto('acusado-<?= $rec['Id'] ?>', 'msg-acusado-<?= $rec['Id'] ?>')">Copiar</button>
                                <span id="msg-acusado-<?= $rec['Id'] ?>" class="copiado-msg bg-success-subtle text-success ms-2 fw-semibold">
                                    ✔ CR copiado
                                </span>
                            <?php endif; ?>
                        </p>

                        <!-- Status -->
                        <p><strong>Status:</strong>
                            <span class="badge <?= $rec['Status'] === 'Resolvido' ? 'badge-success' : 'badge-warning' ?>">
                                <?= $rec['Status'] ?>
                            </span>
                        </p>

                        <!-- Botão para resolver -->
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

<!-- SCRIPT COPIAR TEXTO COM MENSAGEM -->
<script>
function copiarTexto(idTexto, idMensagem) {
    const texto = document.getElementById(idTexto).innerText;

    const input = document.createElement('input');
    input.value = texto;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);

    const msg = document.getElementById(idMensagem);
    msg.classList.add('mostrar');

    setTimeout(() => {
        msg.classList.remove('mostrar');
    }, 2000);
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>