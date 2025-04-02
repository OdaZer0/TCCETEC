<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json; charset=UTF-8");

include "conexao.php";

try {
    // Lendo os dados JSON recebidos
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);

    // Validação do token
    if (!isset($dadosRecebidos['token']) || $dadosRecebidos['token'] !== "meu_token_secreto") {
        echo json_encode(["erro" => "Acesso negado!"]);
        exit();
    }

    $pdo = new Conexao();
    $con = $pdo->getConexao();

    // Variável para o filtro de CR (caso seja fornecido)
    $cr = isset($dadosRecebidos['cr']) ? $dadosRecebidos['cr'] : '';

    // Construção da consulta SQL
    $sql = "SELECT cr, nome, email, avisos FROM Autonomo";
    
    if ($cr !== '') {
        $sql .= " WHERE cr LIKE :cr";
    }

    $stmt = $con->prepare($sql);

    if ($cr !== '') {
        $stmt->bindValue(':cr', "%$cr%");  // Filtro de CR
    }

    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($usuarios);
} catch (Exception $e) {
    echo json_encode(["erro" => "Erro ao buscar autônomos: " . $e->getMessage()]);
}
?>
