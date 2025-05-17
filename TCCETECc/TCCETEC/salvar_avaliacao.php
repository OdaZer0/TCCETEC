<?php
session_start();
require 'conexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
$autonomoId = $_POST['autonomo_id']; // ID do Autônomo (prestador do serviço)
$estrelas = $_POST['estrelas']; // Estrelas dadas pelo cliente
$comentario = $_POST['comentario']; // Comentário do cliente

// Verificação básica
if ($estrelas < 1 || $estrelas > 5) {
    die("A avaliação deve ter entre 1 e 5 estrelas.");
}

// Conectar ao banco de dados
$pdo = Conexao::getConexao();

// Inserir avaliação no banco de dados
$stmt = $pdo->prepare("
    INSERT INTO Avaliacao (AutonomoId, IdCliente, Estrela, Comentario)
    VALUES (:autonomoId, :idCliente, :estrela, :comentario)
");

$stmt->execute([
    ':autonomoId' => $autonomoId,
    ':idCliente' => $usuarioId,
    ':estrela' => $estrelas,
    ':comentario' => $comentario
]);

// Redirecionar para a agenda ou onde for necessário
header("Location: AgendaUsuario.php");
exit();
?>
