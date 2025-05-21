<?php
session_start();
require 'Conexao.php';
$conexao = Conexao::getConexao();

// Verifique se o usuário está logado e se o ID do autônomo está disponível
if (!isset($_SESSION['usuario_id'])) {
    // Caso o usuário não esteja logado, redirecione para o login
    header("Location: login.php");
    exit();
}

$autonomoId = $_SESSION['usuario_id']; // ID do autônomo logado

// Modifique a consulta SQL para filtrar os serviços pelo ID do autônomo
$stmt = $conexao->prepare("SELECT * FROM ServicoAutonomo WHERE IdAutonomo = :idAutonomo");
$stmt->bindParam(':idAutonomo', $autonomoId, PDO::PARAM_INT);
$stmt->execute();

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
            font-family: 'Arial', sans-serif;
        }

        .card-servico {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            background: #ffffff;
        }

        .card-servico:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: rgb(255, 145, 0);
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 10px;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        .btn-editar {
            background-color: #0d6efd;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-editar:hover {
            background-color: #0b5ed7;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .row g-4 {
            margin-top: 20px;
        }

        .text-center {
            text-align: center !important;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
            }

            .card-servico {
                margin-bottom: 20px;
            }

            .btn-editar {
                width: 100%;
            }
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
                    <div class="card-header">
                        <?= htmlspecialchars($linha['Titulo']) ?>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Descrição:</strong> <?= htmlspecialchars($linha['Descricao']) ?></p>
                        <p class="mb-2"><strong>Tipo:</strong> <?= htmlspecialchars($linha['Tipo']) ?></p>
                        <p class="mb-2"><strong>Valor:</strong> R$ <?= number_format($linha['Valor'], 2, ',', '.') ?></p>
                        <p class="mb-2"><strong>Atende a domicílio:</strong> <?= $linha['Domicilio'] ? 'Sim' : 'Não' ?></p>
                    </div>
                    <div>
                        <a href="editar_servico.php?id=<?= $linha['Id'] ?>" class="btn-editar w-100 text-center">Editar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a href="Tela_autonomo.php" class="btn-back">Voltar</a>
    </div>
</div>

</body>
</html>
