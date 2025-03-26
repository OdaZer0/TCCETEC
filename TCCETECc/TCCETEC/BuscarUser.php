<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json; charset=UTF-8");

include "conexao.php";

try {
    // Lendo os dados JSON recebidos
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);

    // Validação do token (simples, ideal seria usar autenticação real)
    if (!isset($dadosRecebidos['token']) || $dadosRecebidos['token'] !== "meu_token_secreto") {
        echo json_encode(["erro" => "Acesso negado!"]);
        exit();
    }

    $pdo = new Conexao();
    $con = $pdo->getConexao();

    // Buscando os usuários no banco
    $sql = "SELECT cr, nome, email, avisos FROM Usuario";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($usuarios);
} catch (Exception $e) {
    echo json_encode(["erro" => "Erro ao buscar usuários: " . $e->getMessage()]);
}
?>
