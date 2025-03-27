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

    // Obtendo o CR do usuário a ser excluído
    if (!isset($dadosRecebidos['cr'])) {
        echo json_encode(["erro" => "CR não informado!"]);
        exit();
    }

    $cr = $dadosRecebidos['cr'];

    $pdo = new Conexao();
    $con = $pdo->getConexao();

    // Verificando se o usuário existe antes de deletar
    $sqlCheck = "SELECT * FROM Autonomo WHERE cr = ?";
    $stmtCheck = $con->prepare($sqlCheck);
    $stmtCheck->bindValue(1, $cr);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() == 0) {
        echo json_encode(["erro" => "Usuário não encontrado!"]);
        exit();
    }

    // Excluindo o usuário do banco
    $sqlDelete = "DELETE FROM Autonomo WHERE cr = ?";
    $stmtDelete = $con->prepare($sqlDelete);
    $stmtDelete->bindValue(1, $cr);
    
    if ($stmtDelete->execute()) {
        echo json_encode(["mensagem" => "Usuário excluído com sucesso!"]);
    } else {
        echo json_encode(["erro" => "Erro ao excluir usuário!"]);
    }
} catch (Exception $e) {
    echo json_encode(["erro" => "Erro ao processar requisição: " . $e->getMessage()]);
}
?>