<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();

$query = $pdo->prepare("SELECT * FROM Usuario WHERE Id = :id");
$query->bindParam(':id', $_SESSION['usuario_id']);
$query->execute();
$user = $query->fetch();

if (!$user) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);

    $updateQuery = $pdo->prepare("UPDATE Usuario SET Nome = :nome, Email = :email, Cep = :cep WHERE Id = :id");
    $updateQuery->bindParam(':nome', $nome);
    $updateQuery->bindParam(':email', $email);
    $updateQuery->bindParam(':cep', $cep);
    $updateQuery->bindParam(':id', $_SESSION['usuario_id']);
    $updateQuery->execute();

    header("Location: PerfilUser.php");
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
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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

        .mb-4 {
            margin-bottom: 2rem !important;
        }

        .form-label {
            font-weight: 600;
            color: #343a40;
        }

        .row {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Editar Perfil</h2>
        <div class="card">
            <div class="card-body">
                <form action="EditarUser.php" method="POST">
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

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
