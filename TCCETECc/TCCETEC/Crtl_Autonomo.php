<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json; charset=UTF-8");

include "Cls_Autonomo.php";

// Criando instâncias
$Gravar = new Gravar();
$GravarPr = new GravarPr();

// Recebendo dados do formulário
$Gravar->setnome(filter_input(INPUT_POST, 'nome'));
$Gravar->setemail(filter_input(INPUT_POST, 'email'));
$Gravar->setsenha(filter_input(INPUT_POST, 'senha'));
$Gravar->setcpf(filter_input(INPUT_POST, 'cpf'));
$Gravar->setcep(filter_input(INPUT_POST, 'cep'));
$Gravar->setarea_atuacao(filter_input(INPUT_POST, 'area_atuacao'));
$Gravar->setnvl_formacao(filter_input(INPUT_POST, 'nvl_formacao'));

// Gerando o hash da senha
$senhaHash = password_hash($Gravar->getsenha(), PASSWORD_BCRYPT);
$Gravar->setsenha($senhaHash);

// Cadastrando usuário no banco
$resultado = $GravarPr->cadastrar($Gravar);

if ($resultado === "Cadastrado com Sucesso!") {
    session_start();
    session_regenerate_id(true);

    $novoId = $GravarPr->ultimoIdInserido();

    // Buscar dados completos do autônomo cadastrado
    $pdo = Conexao::getConexao();
    $query = $pdo->prepare("SELECT Id, Email, CR FROM Autonomo WHERE Id = :id LIMIT 1");
    $query->bindParam(':id', $novoId);
    $query->execute();
    $user = $query->fetch();

    if ($user) {
        $_SESSION['usuario_id'] = $user['Id'];
        $_SESSION['user_email'] = $user['Email'];
        $_SESSION['usuario_tipo'] = 'autonomo';  // Define o tipo do usuário
        $_SESSION['cr'] = $user['CR'];
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['ultima_atividade'] = time();

        header("Location: Tela_autonomo.php");
        exit();
    } else {
        echo json_encode(['erro' => 'Erro ao recuperar dados do autônomo após cadastro.']);
    }
} else {
    echo json_encode(['erro' => $resultado]);
}
