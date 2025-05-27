<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
$pdo = Conexao::getConexao();

// Buscar informações do usuário logado
$query = $pdo->prepare("SELECT * FROM Administrador WHERE Id = :id");
$query->bindParam(':id', $_SESSION['usuario_id']);
$query->execute();
$user = $query->fetch();

// Se o usuário não for encontrado, redireciona
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
    <title>Perfil do Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin-top: 50px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-info h1 {
            font-size: 26px;
            font-weight: bold;
            color: #343a40;
        }

        .profile-info p {
            font-size: 16px;
        }

        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .cards-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .card {
            width: 45%;
            border-radius: 10px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        .card:hover img {
            opacity: 0.7;
        }

        .card-body {
            padding: 20px;
            text-align: center;
            background-color: #18486b;
            color: white;
        }

        .card-body a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .card-body a:hover {
            text-decoration: underline;
        }

        .card-body h3 {
            margin-bottom: 15px;
        }

        .profile-info input {
            width: 100%;
            margin-bottom: 10px;
        }

        .profile-info input:disabled {
            background-color: #f1f1f1;
        }

        .profile-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .text-muted {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <a href="visualizar_reclamacoesfront.php">reclamação</a>

    <?php include 'header.php'; ?>

    <div class="container">
        <div class="profile-section">
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
                <img src="imagens/Fundo de Usuário (Sem passar o Mouse).png" alt="Autônomo">
                <div class="card-body">
                    <h3>Controle de Usuário</h3>
                    <a href="CrtlADM_User.php">Ir para o Controle de Usuário</a>
                </div>
            </div>

            <div class="card">
                <img src="imagens/Fundo de Autônomo (Sem passar o Mouse).png" alt="Autônomo">
                <div class="card-body">
                    <h3>Controle de Autônomos</h3>
                    <a href="CtrlADM_Autonomo.php">Ir para o Controle de Autônomos</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
