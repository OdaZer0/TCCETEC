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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.4/css/all.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card-servico {
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-bottom: 20px;
            transition: transform 0.2s ease-in-out;
        }

        .card-servico:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #5c6bc0;
            color: #fff;
            border-radius: 15px 15px 0 0;
            font-size: 1.25rem;
            padding: 15px;
        }

        .card-body {
            padding: 30px;
        }

        .titulo {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-label {
            font-size: 1.1rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ddd;
            transition: border-color 0.2s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            border-color: #5c6bc0;
            box-shadow: 0 0 5px rgba(92, 107, 192, 0.5);
        }

        .btn-primary {
            background-color: #5c6bc0;
            border-color: #5c6bc0;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #4f5b9e;
            border-color: #4f5b9e;
        }

        .btn-secondary {
            background-color: #607d8b;
            border-color: #607d8b;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background-color: #546e7a;
            border-color: #546e7a;
        }

        .alert {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .list-group-item {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            transition: transform 0.2s ease-in-out;
        }

        .list-group-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .form-check-label {
            font-size: 1.1rem;
        }

        .mt-4 {
            margin-top: 30px;
        }

        .modal-header {
            background-color: #5c6bc0;
            color: white;
        }

        .modal-footer .btn {
            border-radius: 10px;
        }

        .navbar {
            background-color: #5c6bc0;
        }

        .navbar a {
            color: white;
        }

        .navbar a:hover {
            color: #f1f1f1;
        }

        .card-footer {
            text-align: right;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 0 0 15px 15px;
        }

        .card-footer .btn {
            width: 200px;
            font-weight: 600;
            padding: 10px 0;
        }

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
    <div class="card mb-4 card-servico">
        <div class="card-header"><i class="fas fa-plus-circle"></i> Cadastrar Novo Serviço</div>
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
                            <!-- outras opções... -->
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
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <a href="Servicos.php" class="btn btn-secondary mt-3">Meus Serviços</a>
    <a href="Tela_autonomo.html" class="btn btn-secondary mt-3">Voltar</a>

</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
