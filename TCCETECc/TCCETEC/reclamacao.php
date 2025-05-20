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
$crAcusado = isset($_POST['cr_acusado']) ? $_POST['cr_acusado'] : null; // CR do acusado
$descricao = $_POST['descricao']; // Descrição da reclamação

// Verificar se o CR do acusado foi fornecido
if (empty($crAcusado)) {
    die("Erro: O CR do acusado não foi fornecido.");
}

// Verificar se a descrição da reclamação não está vazia
if (empty($descricao)) {
    die("Erro: A descrição da reclamação não pode estar vazia.");
}

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

// Redirecionar para a página de sucesso ou onde for necessário
header("Location: reclamacao_tela.php");
exit();
?>
