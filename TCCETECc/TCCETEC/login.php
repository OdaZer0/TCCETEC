<?php
session_start();

// Definir o tempo de expiração da sessão (por exemplo, 30 minutos de atividade)
$session_lifetime = 30 * 60; // 30 minutos

// Verifica se o tempo da última atividade foi atingido
if (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > $session_lifetime)) {
    // Se a sessão expirou, destrói a sessão e redireciona o usuário para a página de login
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Atualizar o tempo da última atividade
$_SESSION['ultima_atividade'] = time();

// Conectar ao banco de dados
include "conexao.php";
$pdo = Conexao::getConexao(); // ← Adiciona esta linha


// Receber os dados do formulário de login
$username = filter_input(INPUT_POST, 'usuario');
$password = filter_input(INPUT_POST, 'senha');

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

// Se não encontrar, tenta na tabela 'Administradores'
if (!$user) {
    $query = $pdo->prepare("SELECT Id, Email, Senha, 'ADM' AS tipo FROM Administrador WHERE Email = :Email LIMIT 1");
    $query->bindParam(':Email', $username);
    $query->execute();
    $user = $query->fetch();
}

// DEPURAÇÃO – VERIFICANDO O QUE VEIO DO BANCO
//echo "<pre>";
//var_dump($user);
//echo "</pre>";
//exit();

// Verifica se as credenciais são válidas
if ($user && password_verify($password, $user['Senha'])) {
    // Se a senha for válida, cria a sessão
    $_SESSION['usuario_id'] = $user['Id'];
    $_SESSION['user_email'] = $user['Email'];
    $_SESSION['usuario_tipo'] = $user['tipo'];  // Definindo corretamente o tipo de usuário
    $_SESSION['ultima_atividade'] = time(); // Registra o momento da última atividade

    // Redireciona conforme o tipo de usuário
    if ($user['tipo'] == 'autonomo') {
        header("Location: Tela_autonomo.php");
    }
    elseif($user['tipo'] == 'ADM'){
        header("Location: Tela_Adm.php");
    } else {
        header("Location: Tela_Inicio.php");
    }
    exit();
} else {
    // Se as credenciais estiverem incorretas
    echo "Credenciais inválidas!";
}
?>
