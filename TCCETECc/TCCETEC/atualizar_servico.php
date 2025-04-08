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

if ($stmt->execute([$titulo, $descricao, $tipo, $valor, $domicilio, $id])) {
    echo "Serviço atualizado com sucesso!<br>";
    echo '<a href="servicos.php">Voltar à lista</a>';
} else {
    echo "Erro ao atualizar serviço!";
}
