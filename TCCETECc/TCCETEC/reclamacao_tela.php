<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
$crAutonomo = $_GET['cr_autonomo'] ?? '';
$servicoId = $_GET['servico_id'] ?? '';

// Buscar CR do usuário
$pdo = Conexao::getConexao();
$stmt = $pdo->prepare("SELECT CR FROM Usuario WHERE Id = :id LIMIT 1");
$stmt->bindParam(':id', $usuarioId);
$stmt->execute();
$usuario = $stmt->fetch();
$crUsuario = $usuario['CR'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Reclamar do Serviço</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Formulário de Reclamação -->
<div class="form">
    <h4 class="text-center custom-font2">Reclamar do Serviço</h4>

    <form action="reclamacao.php" method="POST">
        <!-- Campos escondidos para enviar os dados do CR -->
        <input type="hidden" name="cr_reclamante" value="<?= htmlspecialchars($crUsuario) ?>">
        <input type="hidden" name="servico_id" value="<?= htmlspecialchars($servicoId) ?>">

        <!-- Tipo da Reclamação -->
        <div class="input-group1">
            <label for="tipo" class="custom-font3">Tipo da Reclamação</label>
            <select class="form-select" name="tipo" id="tipo" required>
                <option value="Denúncia de Usuário">Denúncia de Usuário</option>
                <option value="Denúncia de Autônomo">Denúncia de Autônomo</option>
                <option value="Denúncia Geral">Denúncia Geral</option>
                <option value="Bug">Bug</option>
                <option value="Sugestão">Sugestão</option>
                <option value="Reclamação do Sistema">Reclamação do Sistema</option>
            </select>
        </div>

        <!-- Campo para inserir o CR do acusado -->
        <div class="input-group1">
            <label for="cr_acusado" class="custom-font3">CR do Acusado</label>
            <input type="text" name="cr_acusado" id="cr_acusado" class="form-control" placeholder="Informe o CR do acusado" maxlength="5" required>
        </div>

        <!-- Descrição da Reclamação -->
        <div class="input-group1">
            <label for="descricao" class="custom-font3">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" rows="5" placeholder="Descreva sua reclamação..." required></textarea>
        </div>

        <!-- Botões -->
        <div class="d-flex justify-content-between mt-4">
            <input type="submit" value="Enviar Reclamação" class="btn btn-danger">
            <button type="button" class="btn btn-secondary" onclick="voltar()">Voltar</button>
        </div>
    </form>
</div>

<!-- Script para o botão de Voltar -->
<script>
    function voltar() {
        // Tenta voltar duas páginas no histórico
        window.history.go(-2);
    }
</script>

</body>
</html>
