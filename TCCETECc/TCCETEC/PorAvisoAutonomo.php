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

    // Obtendo o CR do usuário a ser atualizado
    if (!isset($dadosRecebidos['cr'])) {
        echo json_encode(["erro" => "CR não informado!"]);
        exit();
    }

    $cr = $dadosRecebidos['cr'];

    $pdo = new Conexao();
    $con = $pdo->getConexao();

    // Verificando se o usuário existe antes de atualizar
    $sqlCheck = "SELECT * FROM Autonomo WHERE cr = ?";
    $stmtCheck = $con->prepare($sqlCheck);
    $stmtCheck->bindValue(1, $cr);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() == 0) {
        echo json_encode(["erro" => "Usuário não encontrado!"]);
        exit();
    }

    // Atualizando o campo Avisos (Se NULL, inicializa com 0 e adiciona 1, senão incrementa 1)
    $sqlUpdate = "UPDATE Autonomo SET Avisos = COALESCE(Avisos, 0) + 1 WHERE cr = ?";
    $stmtUpdate = $con->prepare($sqlUpdate);
    $stmtUpdate->bindValue(1, $cr);

    if ($stmtUpdate->execute()) {
        echo json_encode(["mensagem" => "Avisos atualizados com sucesso!"]);
    } else {
        echo json_encode(["erro" => "Erro ao atualizar avisos!"]);
    }

} catch (Exception $e) {
    echo json_encode(["erro" => "Erro ao processar requisição: " . $e->getMessage()]);
}
?>