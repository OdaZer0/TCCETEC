<?php
require 'Conexao.php';

if (!isset($_GET['id'])) {
    echo "ID não informado!";
    exit;
}

$conexao = Conexao::getConexao();

$id = $_GET['id'];

$stmt = $conexao->prepare("SELECT * FROM ServicoAutonomo WHERE Id = ?");
$stmt->execute([$id]);
$servico = $stmt->fetch();

if (!$servico) {
    echo "Serviço não encontrado!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Serviço</title>
</head>
<body>

<h2>Editar Serviço</h2>

<form action="atualizar_servico.php" method="post">
    <input type="hidden" name="id" value="<?= $servico['Id'] ?>">

    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= $servico['Titulo'] ?>" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" required><?= $servico['Descricao'] ?></textarea><br><br>

    <label>Tipo:</label><br>
    <input type="text" name="tipo" value="<?= $servico['Tipo'] ?>" required><br><br>

    <label>Valor:</label><br>
    <input type="number" name="valor" value="<?= $servico['Valor'] ?>" step="0.01" required><br><br>

    <label>Atende a domicílio?</label><br>
    <select name="domicilio">
        <option value="1" <?= $servico['Domicilio'] ? 'selected' : '' ?>>Sim</option>
        <option value="0" <?= !$servico['Domicilio'] ? 'selected' : '' ?>>Não</option>
    </select><br><br>

    <button type="submit">Atualizar</button>
</form>

</body>
</html>
