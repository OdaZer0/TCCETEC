<?php
require 'conexao.php';
session_start();

$pdo = Conexao::getConexao();
$stmt = $pdo->query("SELECT s.*, a.Nome AS NomeAutonomo FROM ServicoAutonomo s JOIN Autonomo a ON s.IdAutonomo = a.Id ORDER BY RAND()");
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Disponíveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }
        .servico-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .servico-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f5a623;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }
        .card-header h5 {
            margin: 0;
            font-weight: bold;
        }
        .card-body {
            padding: 20px;
        }
        .btn-contratar {
            background-color: #0d6efd;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-align: center;
            width: 100%;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-contratar:hover {
            background-color: #0056b3;
        }
        .text-muted {
            font-size: 0.9rem;
        }
        .btn-voltar {
            background-color: #6c757d;
            color: white;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-voltar:hover {
            background-color: #5a6268;
        }
        .container {
            max-width: 1200px;
        }
        /* Responsividade */
        @media (max-width: 768px) {
            .card-header h5 {
                font-size: 1.2rem;
            }
            .servico-card {
                margin-bottom: 20px;
            }
            .btn-contratar {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="text-center fw-bold mb-5">Serviços Disponíveis</h2>

    <div class="row g-4">
        <?php foreach ($servicos as $servico): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card servico-card h-100">
                    <div class="card-header">
                        <h5><?= htmlspecialchars($servico['Titulo']) ?></h5>
                        <h6 class="text-muted">Por <?= htmlspecialchars($servico['NomeAutonomo']) ?></h6>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="card-text"><?= htmlspecialchars($servico['Descricao']) ?></p>
                        <p><strong>Tipo:</strong> <?= $servico['Tipo'] ?><br>
                           <strong>Valor:</strong> R$<?= number_format($servico['Valor'], 2, ',', '.') ?></p>
                        
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <form method="post" action="solicitar_servico.php" class="mt-3">
                                <input type="hidden" name="id_servico" value="<?= $servico['Id'] ?>">
                                <input type="hidden" name="id_autonomo" value="<?= $servico['IdAutonomo'] ?>">
                                <div class="mb-2">
                                    <label for="data_solicitada" class="form-label">Data desejada:</label>
                                    <input type="date" name="data_solicitada" class="form-control" required>
                                </div>
                                <button type="submit" class="btn-contratar">Contratar</button>
                            </form>
                        <?php else: ?>
                            <p class="mt-3 text-muted text-center"><em>Faça login como usuário para contratar</em></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a href="Tela_Inicio.php" class="btn btn-voltar btn-lg">Voltar</a>
    </div>
</div>

</body>
</html>
