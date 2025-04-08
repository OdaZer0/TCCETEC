<?php
require 'Conexao.php';
$conexao = Conexao::getConexao();

$stmt = $conexao->query("SELECT * FROM ServicoAutonomo");
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Serviços Cadastrados</title>
    <style>
        .servico-bloco {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            max-width: 500px;
        }

        .btn-editar {
            background-color: #007BFF;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-editar:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Serviços Cadastrados</h2>

<?php foreach ($servicos as $linha): ?>
    <div class="servico-bloco">
        <strong>Título:</strong> <?= $linha['Titulo'] ?><br>
        <strong>Descrição:</strong> <?= $linha['Descricao'] ?><br>
        <strong>Tipo:</strong> <?= $linha['Tipo'] ?><br>
        <strong>Valor:</strong> R$ <?= number_format($linha['Valor'], 2, ',', '.') ?><br>
        <strong>Atende a domicílio:</strong> <?= $linha['Domicilio'] ? 'Sim' : 'Não' ?><br>
        <br>
        <a href="editar_servico.php?id=<?= $linha['Id'] ?>" class="btn-editar">Editar</a>
    </div>
<?php endforeach; ?>

</body>
</html>
