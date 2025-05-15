<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para editar o serviço.");
}

$autonomoId = $_SESSION['usuario_id'];  // Pega o ID do autônomo logado
$idServico = $_GET['id'];  // Pega o ID do serviço da URL

$pdo = Conexao::getConexao();

// Consultar se o serviço existe e pertence ao autônomo logado
$stmt = $pdo->prepare("SELECT * FROM ServicoAutonomo WHERE Id = :id AND IdAutonomo = :idAutonomo");
$stmt->bindParam(':id', $idServico);
$stmt->bindParam(':idAutonomo', $autonomoId);
$stmt->execute();

$servico = $stmt->fetch();

if (!$servico) {
    die("Serviço não encontrado ou você não tem permissão para editar.");
}

// Atualizar o serviço
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $domicilio = isset($_POST['domicilio']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE ServicoAutonomo SET Titulo = :titulo, Descricao = :descricao, Tipo = :tipo, Valor = :valor, Domicilio = :domicilio WHERE Id = :id");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':domicilio', $domicilio);
    $stmt->bindParam(':id', $idServico);

    if ($stmt->execute()) {
        header("Location: Servicos.php");
        exit();
    } else {
        $erro = "Erro ao atualizar o serviço.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            font-size: 1.1rem;
        }

        .btn-primary {
            background-color: #5c6bc0;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #4f5b9e;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Editar Serviço</h2>

    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" id="titulo" value="<?= htmlspecialchars($servico['Titulo']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" id="descricao" rows="3" required><?= htmlspecialchars($servico['Descricao']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" id="tipo" value="<?= htmlspecialchars($servico['Tipo']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor (R$)</label>
            <input type="number" name="valor" class="form-control" id="valor" value="<?= htmlspecialchars($servico['Valor']) ?>" step="0.01" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="domicilio" class="form-check-input" id="domicilio" <?= $servico['Domicilio'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="domicilio">Atende a domicílio</label>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>

    <div class="mt-3 text-center">
        <a href="Servicos.php" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
