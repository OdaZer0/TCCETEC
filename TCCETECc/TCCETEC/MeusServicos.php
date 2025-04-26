<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();
$autonomoId = $_SESSION['usuario_id'];
$mensagem = "";

// Excluir serviço
if (isset($_GET['excluir'])) {
    $idExcluir = $_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM ServicoAutonomo WHERE Id = :id AND IdAutonomo = :idAutonomo");
    $stmt->bindParam(':id', $idExcluir);
    $stmt->bindParam(':idAutonomo', $autonomoId);
    if ($stmt->execute()) {
        $mensagem = "Serviço excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir o serviço.";
    }
}

// Cadastro com validação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $valor = trim($_POST['valor'] ?? '');
    $domicilio = isset($_POST['domicilio']) ? 1 : 0;

    if (!empty($titulo) && !empty($descricao) && !empty($tipo) && !empty($valor)) {
        // Inserir no banco de dados
        $stmt = $pdo->prepare("INSERT INTO ServicoAutonomo (Titulo, Descricao, Tipo, Valor, Domicilio, IdAutonomo)
            VALUES (:titulo, :descricao, :tipo, :valor, :domicilio, :idAutonomo)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':domicilio', $domicilio);
        $stmt->bindParam(':idAutonomo', $autonomoId);

        if ($stmt->execute()) {
            $mensagem = "Serviço cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar o serviço.";
        }
    } else {
        // Mensagem de erro se algum campo obrigatório não foi preenchido
        $mensagem = "Por favor, preencha todos os campos obrigatórios.";
    }
}

// Buscar serviços
$stmt = $pdo->prepare("SELECT * FROM ServicoAutonomo WHERE IdAutonomo = :id");
$stmt->bindParam(':id', $autonomoId);
$stmt->execute();
$servicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 960px; margin-top: 40px; margin-bottom: 40px; }
        .card-servico { border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .titulo { font-size: 1.4rem; font-weight: bold; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <h2 class="text-center mb-4">Meus Serviços</h2>

    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <!-- Formulário de cadastro -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Cadastrar Novo Serviço</div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Selecione o tipo</option>
                            <option value="Adestramento de Animais">Adestramento de Animais</option>
                            <option value="Acompanhamento Escolar">Acompanhamento Escolar</option>
                            <option value="Aulas de Dança">Aulas de Dança</option>
                            <option value="Aulas de Idiomas">Aulas de Idiomas</option>
                            <option value="Aulas de Música">Aulas de Música</option>
                            <option value="Aulas de Reforço Escolar">Aulas de Reforço Escolar</option>
                            <option value="Banho e Tosa">Banho e Tosa</option>
                            <option value="Cabelereiro(a)">Cabelereiro(a)</option>
                            <option value="Consultoria Financeira">Consultoria Financeira</option>
                            <option value="Conserto de Aparelhos Eletrônicos">Conserto de Aparelhos Eletrônicos</option>
                            <option value="Conserto de Celulares">Conserto de Celulares</option>
                            <option value="Conserto de Computadores">Conserto de Computadores</option>
                            <option value="Cozinheira(o) ou Personal Chef">Cozinheira(o) ou Personal Chef</option>
                            <option value="Cuidador de Animais">Cuidador de Animais</option>
                            <option value="Cuidador de Idosos">Cuidador de Idosos</option>
                            <option value="Design de Interiores">Design de Interiores</option>
                            <option value="Design Gráfico">Design Gráfico</option>
                            <option value="Design de Sobrancelhas">Design de Sobrancelhas</option>
                            <option value="Diarista ou Faxineira">Diarista ou Faxineira</option>
                            <option value="Eletricista">Eletricista</option>
                            <option value="Encanador">Encanador</option>
                            <option value="Esteticista">Esteticista</option>
                            <option value="Fotografia Profissional">Fotografia Profissional</option>
                            <option value="Freelancer em TI">Freelancer em TI</option>
                            <option value="Instalação de Ar-Condicionado">Instalação de Ar-Condicionado</option>
                            <option value="Jardinagem">Jardinagem</option>
                            <option value="Maquiador(a)">Maquiador(a)</option>
                            <option value="Manicure e Pedicure">Manicure e Pedicure</option>
                            <option value="Marcenaria">Marcenaria</option>
                            <option value="Montagem de Móveis">Montagem de Móveis</option>
                            <option value="Motorista Particular">Motorista Particular</option>
                            <option value="Passeador de Cães">Passeador de Cães</option>
                            <option value="Pintor de Paredes">Pintor de Paredes</option>
                            <option value="Psicopedagogo">Psicopedagogo</option>
                            <option value="Redator e Revisor de Textos">Redator e Revisor de Textos</option>
                            <option value="Serviços de Costura">Serviços de Costura</option>
                            <option value="Serviços de Limpeza Pós-Obra">Serviços de Limpeza Pós-Obra</option>
                            <option value="Serviços de Mudança">Serviços de Mudança</option>
                            <option value="Serviços Gerais de Construção">Serviços Gerais de Construção</option>
                            <option value="Técnico em Informática">Técnico em Informática</option>
                            <option value="Tradutor">Tradutor</option>
                            <option value="Veterinário(a)">Veterinário(a)</option>
                            <option value="Web Designer">Web Designer</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Valor (R$)</label>
                        <input type="number" name="valor" step="0.01" class="form-control" required>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="domicilio" id="domicilio">
                            <label class="form-check-label" for="domicilio">
                                Atende a domicílio
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <a href="Servicos.php" class="btn btn-secondary mt-3">Meus Serviços</a>
    <a href="Tela_autonomo.html" class="btn btn-secondary mt-3">Voltar</a>

<?php include 'footer.php'; ?>
</body>
</html>
