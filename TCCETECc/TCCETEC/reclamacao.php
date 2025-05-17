<?php
session_start();
require 'conexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verificar se o CR do usuário está disponível na sessão
if (!isset($_SESSION['cr'])) {
    die("Erro: CR do usuário não encontrado na sessão.");
}

$usuarioId = $_SESSION['usuario_id']; // ID do usuário
$crReclamante = $_SESSION['cr']; // CR do reclamante (Agora sendo coletado corretamente)
$tipoReclamacao = $_POST['tipo']; // Tipo de reclamação
$crAcusado = $_POST['cr_acusado']; // CR do acusado
$descricao = $_POST['descricao']; // Descrição da reclamação

// Conectar ao banco de dados
$pdo = Conexao::getConexao();

// Inserir reclamação no banco de dados
$stmt = $pdo->prepare("
    INSERT INTO ReclamaoDenuncia (Tipo, CR_QuemReclamou, CR_Acusado, Descricao)
    VALUES (:tipo, :crReclamante, :crAcusado, :descricao)
");

$stmt->execute([
    ':tipo' => $tipoReclamacao,
    ':crReclamante' => $crReclamante,
    ':crAcusado' => $crAcusado,
    ':descricao' => $descricao
]);

// Redirecionar para a agenda ou onde for necessário
header("Location: AgendaUsuario.php");
exit();
?>
