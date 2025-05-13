<?php
require 'Conexao.php';

$conexao = Conexao::getConexao();

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$tipo = $_POST['tipo'];
$valor = $_POST['valor'];
$domicilio = $_POST['domicilio'];

$stmt = $conexao->prepare("UPDATE ServicoAutonomo 
    SET Titulo = ?, Descricao = ?, Tipo = ?, Valor = ?, Domicilio = ? 
    WHERE Id = ?");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Serviço</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin-top: 50px;
        }

        h1 {
            color: #3498db;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .btn-back {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-back:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .form-check-label {
            font-size: 1rem;
        }

        .alert {
            font-size: 1.2rem;
            text-align: center;
            margin-top: 20px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Atualização de Serviço</h1>

        <?php if ($stmt->execute([$titulo, $descricao, $tipo, $valor, $domicilio, $id])): ?>
            <div class="alert alert-success">
                Serviço atualizado com sucesso!
            </div>
            <a href="servicos.php" class="btn-back">Voltar à lista</a>
        <?php else: ?>
            <div class="alert alert-danger">
                Erro ao atualizar serviço!
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
