<?php
session_start();
include "Cls_User.php"; // Supondo que você tenha uma classe para gerenciar o usuário

// Conectar ao banco de dados
$pdo = Conexao::getConexao();

// Receber os dados do formulário de login
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// Tentar buscar o usuário na tabela 'Usuarios'
$query = $pdo->prepare("SELECT Id, Email, Senha, 'usuario' AS tipo FROM Usuario WHERE Email = :Email LIMIT 1");
$query->bindParam(':Email', $username);
$query->execute();
$user = $query->fetch();

// Se não encontrar, tenta na tabela 'Autonomos'
if (!$user) {
    $query = $pdo->prepare("SELECT Id, Email, Senha, 'autonomo' AS tipo FROM Autonomo WHERE Email = :Email LIMIT 1");
    $query->bindParam(':Email', $username);
    $query->execute();
    $user = $query->fetch();
}

if ($user && password_verify($password, $user['Senha'])) {
    // Se a senha for válida, criamos a sessão
    $_SESSION['usuario_id'] = $user['Id'];
    $_SESSION['user_email'] = $user['Email'];
    $_SESSION['ultima_atividade'] = time(); // Registra o momento da última atividade

    // Redireciona para a Tela Inicial com base na tabela de origem
    if ($user['tipo'] == 'autonomo') {
        // O usuário foi encontrado na tabela de 'Autonomo', então redireciona para a tela de autônomos
        header("Location: Tela_autonomo.html");
    } else {
        // O usuário foi encontrado na tabela de 'Usuario', então redireciona para a tela de usuários
        header("Location: Tela_inicio.html");
    }

    exit();
} else {
    // Se as credenciais estiverem incorretas
    echo "Credenciais inválidas!";
}
?>
