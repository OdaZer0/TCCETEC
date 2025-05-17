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

// Tentar buscar o usuário na tabela 'Usuarios' (Agora com o CR do usuário)
$query = $pdo->prepare("SELECT Id, Email, Senha, CR, 'usuario' AS tipo FROM Usuario WHERE Email = :Email LIMIT 1");
$query->bindParam(':Email', $username);
$query->execute();
$user = $query->fetch();

// Se não encontrar, tenta na tabela 'Autonomos' (Agora com o CR do autônomo)
if (!$user) {
    $query = $pdo->prepare("SELECT Id, Email, Senha, CR, 'autonomo' AS tipo FROM Autonomo WHERE Email = :Email LIMIT 1");
    $query->bindParam(':Email', $username);
    $query->execute();
    $user = $query->fetch();
}

// Se não encontrar, tenta na tabela 'Administradores' (Sem CR, pois não existe para admins)
if (!$user) {
    $query = $pdo->prepare("SELECT Id, Email, Senha, 'ADM' AS tipo FROM Administrador WHERE Email = :Email LIMIT 1");
    $query->bindParam(':Email', $username);
    $query->execute();
    $user = $query->fetch();
}

// Verifica se as credenciais são válidas
if ($user && password_verify($password, $user['Senha'])) {
    // Se a senha for válida, cria a sessão
    $_SESSION['usuario_id'] = $user['Id'];    // Armazenando o ID do usuário na sessão
    $_SESSION['user_email'] = $user['Email'];  // Armazenando o e-mail na sessão
    $_SESSION['usuario_tipo'] = $user['tipo']; // Armazenando o tipo de usuário na sessão
    $_SESSION['ultima_atividade'] = time();    // Registra o momento da última atividade

    // Verificar se o CR foi retornado e armazená-lo na sessão
    if (isset($user['CR'])) {
        $_SESSION['cr'] = $user['CR'];  // Armazenando o CR do usuário na sessão
    } else {
        // Para Administradores, o CR não existe, então definimos como null
        $_SESSION['cr'] = null;
    }

    // Redireciona conforme o tipo de usuário
    if ($user['tipo'] == 'autonomo') {
        header("Location: Tela_autonomo.php");
    } elseif ($user['tipo'] == 'ADM') {
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
