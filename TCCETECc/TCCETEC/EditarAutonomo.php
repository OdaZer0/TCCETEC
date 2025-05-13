<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();

$query = $pdo->prepare("SELECT * FROM Autonomo WHERE Id = :id");
$query->bindParam(':id', $_SESSION['usuario_id']);
$query->execute();
$user = $query->fetch();

if (!$user) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome');
    $email = filter_input(INPUT_POST, 'email');
    $cep = filter_input(INPUT_POST, 'cep');
    $AreaAtuacao = filter_input(INPUT_POST, 'AreaAtuacao');
    $NivelFormacao = filter_input(INPUT_POST, 'NivelFormacao');

    $updateQuery = $pdo->prepare("UPDATE Autonomo SET Nome = :nome, Email = :email, Cep = :cep, AreaAtuacao = :AreaAtuacao, NivelFormacao = :NivelFormacao WHERE Id = :id");
    $updateQuery->bindParam(':nome', $nome);
    $updateQuery->bindParam(':email', $email);
    $updateQuery->bindParam(':cep', $cep);
    $updateQuery->bindParam(':AreaAtuacao', $AreaAtuacao);
    $updateQuery->bindParam(':NivelFormacao', $NivelFormacao);
    $updateQuery->bindParam(':id', $_SESSION['usuario_id']);
    $updateQuery->execute();

    header("Location: PerfilAutonomo.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
            padding: 40px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        h2 {
            font-size: 2rem;
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 15px;
            font-size: 1.1rem;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 30px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .d-flex {
            justify-content: center;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .mb-4 {
            margin-bottom: 2rem !important;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Editar Perfil</h2>
        <div class="card">
            <div class="card-body">
                <form action="EditarAutonomo.php" method="POST">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nome:</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($user['Nome']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">CEP:</label>
                            <input type="text" name="cep" class="form-control" value="<?php echo htmlspecialchars($user['Cep']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Área de Atuação:</label>
                            <input type="text" name="AreaAtuacao" class="form-control" value="<?php echo htmlspecialchars($user['AreaAtuacao']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nível de Formação:</label>
                            <input type="text" name="NivelFormacao" class="form-control" value="<?php echo htmlspecialchars($user['NivelFormacao']); ?>" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    
</body>
</html>
