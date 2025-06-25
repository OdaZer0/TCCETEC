<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();

$query = $pdo->prepare("SELECT * FROM Administrador WHERE Id = :id");
$query->bindParam(':id', $_SESSION['usuario_id']);
$query->execute();
$user = $query->fetch();

if (!$user) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #ffffff;
            max-width: 1100px;
            margin: 60px auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .profile-info {
            flex: 1;
            padding-right: 30px;
        }

        .profile-info h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control[disabled] {
            background-color: #f8f9fa;
        }

        .profile-image img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #0d6efd;
        }

        .btn-logout {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 40px;
        }

        .card {
            flex: 1 1 calc(33.333% - 20px);
            background-color: #fff;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
            background-color: #18486b;
            text-align: center;
        }

        .card-body h3 {
            color: white;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-body a {
            color: #ffffff;
            text-decoration: underline;
            font-weight: bold;
        }

        .card-body a:hover {
            text-decoration: none;
        }

        @media (max-width: 992px) {
            .card {
                flex: 1 1 calc(50% - 15px);
            }
        }

        @media (max-width: 576px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-info {
                padding-right: 0;
                margin-bottom: 30px;
            }

            .cards-container {
                flex-direction: column;
            }

            .card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <div class="profile-header">
            <div class="profile-info">
                <h1>Perfil do Administrador</h1>
                <div class="mb-3">
                    <label class="form-label">Nome:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Nome']); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">CPF:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Cpf']); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" disabled>
                </div>
                <form action="logout.php" method="POST">
                    <button type="submit" class="btn-logout">Sair</button>
                </form>
            </div>
            <div class="profile-image">
                <img src="path_to_image/<?php echo $user['Foto'] ?: 'default_profile_picture.png'; ?>" alt="Foto do Usuário">
            </div>
        </div>

        <div class="cards-container">
            <div class="card">
                <img src="imagens/Fundo de Usuário (Sem passar o Mouse).png" alt="Controle de Usuários">
                <div class="card-body">
                    <h3>Controle de Usuários</h3>
                    <a href="CrtlADM_User.php">Acessar</a>
                </div>
            </div>

            <div class="card">
                <img src="imagens/Fundo de Autônomo (Sem passar o Mouse).png" alt="Controle de Autônomos">
                <div class="card-body">
                    <h3>Controle de Autônomos</h3>
                    <a href="CtrlADM_Autonomo.php">Acessar</a>
                </div>
            </div>

            <div class="card">
                <img src="imagens/Reclamacao.jpeg" alt="Visualizar Reclamações">
                <div class="card-body">
                    <h3>Reclamações</h3>
                    <a href="visualizar_reclamacoesfront.php">Acessar</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
