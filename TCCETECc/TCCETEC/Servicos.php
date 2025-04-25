<?php
require 'Conexao.php';
$conexao = Conexao::getConexao();

$stmt = $conexao->query("SELECT * FROM ServicoAutonomo");
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Serviços Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-servico {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            background: #ffffff;
        }
        .card-servico:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .btn-editar {
            background-color: #0d6efd;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            text-decoration: none;
        }
        .btn-editar:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center fw-bold mb-4">Serviços Cadastrados</h2>

    <div class="row g-4">
        <?php foreach ($servicos as $linha): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card card-servico p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold"><?= htmlspecialchars($linha['Titulo']) ?></h5>
                        <p class="mb-1"><strong>Descrição:</strong> <?= htmlspecialchars($linha['Descricao']) ?></p>
                        <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($linha['Tipo']) ?></p>
                        <p class="mb-1"><strong>Valor:</strong> R$ <?= number_format($linha['Valor'], 2, ',', '.') ?></p>
                        <p class="mb-1"><strong>Atende a domicílio:</strong> <?= $linha['Domicilio'] ? 'Sim' : 'Não' ?></p>
                    </div>
                    <div class="mt-3">
                        <a href="editar_servico.php?id=<?= $linha['Id'] ?>" class="btn-editar w-100 text-center">Editar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
