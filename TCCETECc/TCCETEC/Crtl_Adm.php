<?php
session_start();  // Mover para o início do script

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json; charset=UTF-8");

include "Cls_Adm.php";

// Criando instâncias
$Gravar = new Gravar();
$GravarPr = new GravarPr();

// Recebendo dados do formulário
$Gravar->setnome(filter_input(INPUT_POST, 'nome'));
$Gravar->setemail(filter_input(INPUT_POST, 'email'));
$Gravar->setsenha(filter_input(INPUT_POST, 'senha'));
$Gravar->setcpf(filter_input(INPUT_POST, 'cpf'));
$Gravar->setcep(filter_input(INPUT_POST, 'cep'));
$Gravar->setcargo(filter_input(INPUT_POST, 'cargo'));

// Debug: Verificar os dados recebidos
var_dump($_POST);  // Para conferir os dados do formulário

// Gerando o hash da senha com salt
$senhaHash = password_hash($Gravar->getsenha(), PASSWORD_BCRYPT);
$Gravar->setsenha($senhaHash);

// Cadastrando usuário no banco
$resultado = $GravarPr->cadastrar($Gravar);

if ($resultado === "Cadastrado com Sucesso!") {
    // Criar sessão para manter o usuário logado após o cadastro
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = $GravarPr->ultimoIdInserido(); // Pega o ID do novo usuário
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['ultima_atividade'] = time();

    // Redireciona para a Tela Inicial
    header("Location: Tela_Adm.php");
    exit();
} else {
    echo json_encode(["erro" => $resultado]);
}
