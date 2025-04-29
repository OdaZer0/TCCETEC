<?php
session_start();
include "conexao.php";

// Verifica se o usuário é administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    die("Acesso restrito a administradores.");
}

$pdo = Conexao::getConexao();

// Buscar as reclamações do banco de dados
$stmt = $pdo->prepare("SELECT * FROM ReclamaoDenuncia WHERE Status != 'Resolvido' ORDER BY Data DESC");
$stmt->execute();
$reclamacoes = $stmt->fetchAll();

if (!$reclamacoes) {
    echo "<p>Nenhuma reclamação encontrada.</p>";
} else {
    // Exibe as reclamações
    foreach ($reclamacoes as $reclamacao) {
        $status = $reclamacao['Status'] == 'Fechado' ? 'Fechado' : 'Aberto';
        echo "<div class='reclamacao'>
                <div class='reclamacao-header'>
                    <h5>{$reclamacao['Tipo']}</h5>
                    <button class='btn btn-info' data-bs-toggle='collapse' data-bs-target='#reclamacao-{$reclamacao['Id']}'>Expandir</button>
                </div>
                <div id='reclamacao-{$reclamacao['Id']}' class='collapse'>
                    <div class='reclamacao-body'>
                        <p><strong>Descrição:</strong> {$reclamacao['Descricao']}</p>
                        <p><strong>CR do Reclamante:</strong> {$reclamacao['CR_QuemReclamou']}</p>
                        <p><strong>CR do Acusado:</strong> {$reclamacao['CR_Acusado']}</p>
                        <p><strong>Data:</strong> {$reclamacao['Data']}</p>
                        <p><strong>Status:</strong> {$status}</p>
                        <div class='d-flex'>
                            <form method='POST' action='fechar_reclamacao.php'>
                                <input type='hidden' name='reclamacao_id' value='{$reclamacao['Id']}'>
                                <button type='submit' class='btn btn-success'>Fechar</button>
                            </form>
                            <form method='POST' action='salvar_como_grave.php'>
                                <input type='hidden' name='reclamacao_id' value='{$reclamacao['Id']}'>
                                <button type='submit' class='btn btn-danger ms-2'>Salvar como Grave</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><br>";
    }
}
?>
