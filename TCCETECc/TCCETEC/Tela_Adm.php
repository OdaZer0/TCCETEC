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
        <link rel="stylesheet" href="styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css"> 
    <link rel="stylesheet" href="estilos2.css">
    <link rel="stylesheet" href="estilos3.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                text-align: center;
            }
            .container {
                width: 60%;
                margin: 20px auto;
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .profile-info {
                text-align: left;
                flex: 1;
            }
            .profile-info h1 {
                font-size: 24px;
                margin-bottom: 15px;
            }
            .profile-info p {
                font-size: 18px;
                margin: 5px 0;
            }
            .profile-image img {
                width: 150px;
                height: 150px;
                border-radius: 50%;
            }
            .cards-container {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-top: 20px;
            }
            .card {
                width: 250px;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s;
            }
            
            .card img {
                width: 100%;
               
            }
           
            .card .card-body {
                background-color: orange;
                padding: 15px;
                color: white;
                text-align: center;
            }
            .card .card-body a {
                color: white;
                text-decoration: none;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
    <?php include 'header.php'; ?>
        <div class="container">
            <div class="profile-info">
                <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">NOME: </label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Nome']); ?>" disabled>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">CPF: </label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Cpf']); ?>" disabled>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">EMAIL: </label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" disabled>
            </div>
        </div>
        </div>
        </div>
            </div>
            <div class="profile-image">
                <img src="" alt="Foto do usuário">
            </div>
        </div>
        <div class="cards-container">
            <div class="card">
                <img src="imagens/Fundo de Usuário (Sem passar o Mouse).png" class="default-image" alt="Autônomo">
                <img src="imagens/Fundo de Usuário (Com o mouse em cima).png" class="hover-image" alt="Autônomo" style="position: absolute; top: 0; left: 0; opacity: 0;">
                <div class="card-body">
                    <h3>Controle de Usuário</h3>
                    <a href="CrtlADM_User.php">Controle de Usuário</a>
                </div>
            </div>
            <div class="card">
                <img src="imagens/Fundo de Autônomo (Sem passar o mouse).png" class="default-image" alt="Usuário">
                <img src="imagens/Fundo de Usuário (Com o mouse em cima).png" class="hover-image" alt="Usuário" style="position: absolute; top: 0; left: 0; opacity: 0;">
                <div class="card-body" style="background-color: #18486b;">
                    <h3>Controle de Autonômo</h3>
                    <a href="CtrlADM_Autonomo.php">Controle de Autonômo</a>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    </html>
    
   
