<?php
session_start();
include "conexao.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para enviar uma denúncia ou reclamação.");
}

$pdo = Conexao::getConexao();

// Recebe os dados do formulário
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$cr_acusado = filter_input(INPUT_POST, 'cr_acusado', FILTER_VALIDATE_INT);
$cr_quem_reclamou = null;

// Pega o ID da sessão
$user_id = $_SESSION['usuario_id'];

// Tenta identificar se é usuário ou autônomo
$stmt = $pdo->prepare("SELECT CR FROM Usuario WHERE Id = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$usuario = $stmt->fetch();

if ($usuario) {
    $cr_quem_reclamou = $usuario['CR'];
} else {
    $stmt = $pdo->prepare("SELECT CR FROM Autonomo WHERE Id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $autonomo = $stmt->fetch();

    if ($autonomo) {
        $cr_quem_reclamou = $autonomo['CR'];
    } else {
        die("CR do usuário não encontrado.");
    }
}

// Validação adicional se necessário
$requer_cr = in_array($tipo, ['Denúncia de Usuário', 'Denúncia de Autônomo']);
if ($requer_cr && empty($cr_acusado)) {
    die("Este tipo de denúncia exige o CR do acusado.");
}

// Insere na tabela ReclamaoDenuncia
$stmt = $pdo->prepare("
    INSERT INTO ReclamaoDenuncia (Tipo, Descricao, CR_QuemReclamou, CR_Acusado)
    VALUES (:tipo, :descricao, :cr_quem_reclamou, :cr_acusado)
");

$stmt->bindParam(':tipo', $tipo);
$stmt->bindParam(':descricao', $descricao);
$stmt->bindParam(':cr_quem_reclamou', $cr_quem_reclamou);
$stmt->bindParam(':cr_acusado', $cr_acusado);

if ($stmt->execute()) {
    echo "<script>alert('Reclamação enviada com sucesso!'); window.location.href = 'Tela_Inicio.html';</script>";
} else {
    echo "<script>alert('Erro ao enviar a reclamação.'); window.history.back();</script>";
}
