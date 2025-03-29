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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">
    <title>Perfil de Usuário</title>
</head>
<body>

<style>

.custom-font {
    font-family: 'Arial', sans-serif;
    font-weight: 600;
    color: #343a40;
}


.container {
    max-width: 1200px;
    padding-top: 50px;
    padding-bottom: 50px;
}


.profile-pic {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 5px solid #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}


.profile-table {
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border: 1px solid #dee2e6;
}

.profile-table th {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
}

.profile-table td {
    background-color: #ffffff;
}

.profile-table tbody tr:hover {
    background-color: #f1f1f1;
}


.card {
    border: 1px solid #dee2e6;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}


.card-header {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 1.1rem;
}

.card-body {
    background-color: #ffffff;
}

.card-body .list-group-item {
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    margin-bottom: 8px;
    padding: 15px;
}

.card-body .list-group-item:hover {
    background-color: #f1f1f1;
}


.btn-outline-warning {
    border-radius: 50px;
    padding: 10px 20px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-outline-warning:hover {
    background-color: #0069d9;
    color: #ffffff;
}


.list-group-item strong {
    color: #0069d9;
}

.mb-4 {
    margin-bottom: 30px !important;
}

.text-center {
    text-align: center !important;


.card-header.bg-primary {
    background-color: #007bff !important;
}

.card-header.bg-success {
    background-color: #0056b3 !important;
}

/* Estilo do botão */
.btn-primary {
    background-color: #007bff; 
    border-color: #007bff;   
    color: white;              
    padding: 15px 30px;        
    font-size: 18px;           
    font-weight: bold;         
    border-radius: 50px;       
    transition: background-color 0.3s ease; 
}

.btn-primary:hover {
    background-color: #0056b3; 
    border-color: #0056b3;     
}

.btn-primary:focus, .btn-primary:active {
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5); 
}

    </style>
<?php include 'header.php'; ?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">
    <title>Perfil de Usuário</title>
</head>
<body>


<div class="container mt-5">
    
    <div class="row justify-content-center mb-4">
        <div class="col-md-3 text-center">
            
            <img src="imagens/Fundo de Autônomo (Sem passar o mouse).png" alt="Foto do Usuário" class="img-fluid rounded-circle profile-pic">
        </div>
        <div class="col-md-9 d-flex align-items-center justify-content-center">
            <h2 class="text-center custom-font mb-0">Perfil do Autônomo</h2>
        </div>
    </div>

 
    <div class="table-responsive">
        <table class="table table-bordered table-striped profile-table">
            <tbody>
                <tr>
                    <th class="table-light">Nome:</th>
                    <td><?php echo htmlspecialchars($user['Nome']); ?></td>
                </tr>
                <tr>
                    <th class="table-light">Email:</th>
                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                </tr>
                <tr>
                    <th class="table-light">CR:</th>
                    <td><?php echo htmlspecialchars($user['CR']); ?></td>
                </tr>
                <tr>
                    <th class="table-light">CEP:</th>
                    <td><?php echo htmlspecialchars($user['Cep']); ?></td>
                </tr>
                <tr>
                    <th class="table-light">Área de Atuação:</th>
                    <td><?php echo htmlspecialchars($user['AreaAtuacao']); ?></td>
                </tr>
                <tr>
                    <th class="table-light">Nível de Formação:</th>
                    <td><?php echo htmlspecialchars($user['NivelFormacao']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5>Histórico de Contratação</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">Contratação 1 - <strong>Data:</strong> 15/02/2025</li>
                <li class="list-group-item">Contratação 2 - <strong>Data:</strong> 01/03/2025</li>
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5>Avaliações</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">Avaliação 1 - <strong>Nota:</strong> 4.5/5</li>
                <li class="list-group-item">Avaliação 2 - <strong>Nota:</strong> 4.8/5</li>
            </ul>
        </div>
    </div>


<div class="d-flex justify-content-center">
    <a href="EditarUser.php" class="btn btn-primary btn-lg rounded-pill">Editar Perfil</a>
</div>

    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
