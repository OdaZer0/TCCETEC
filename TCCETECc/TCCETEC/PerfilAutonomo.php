<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();

$query = $pdo->prepare("SELECT * FROM Autonomo WHERE Id = :Id");
$query->bindParam(':Id', $_SESSION['usuario_id']);  // Corrigido: agora usa :Id com 'I' maiúsculo
$query->execute();
$user = $query->fetch();


if (!$user) {
    header("Location: login.php");
    exit();
}

// Se o formulário de upload foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];

    // Verificar se o arquivo foi carregado corretamente
    if ($foto['error'] == UPLOAD_ERR_OK) {
        // Verificar tipo de arquivo para garantir que seja uma imagem
        $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array(strtolower($extensao), $tiposPermitidos)) {
            // Abrir o arquivo de imagem em binário
            $imagemConteudo = file_get_contents($foto['tmp_name']);

            // Atualizar o banco de dados com o conteúdo binário da imagem
            $query = $pdo->prepare("UPDATE Autonomo SET Foto = :foto WHERE Id = :id");
            $query->bindParam(':foto', $imagemConteudo, PDO::PARAM_LOB);
            $query->bindParam(':id', $_SESSION['usuario_id']);
            $query->execute();

            // Redirecionar após o upload
            header("Location: PerfilAutonomo.php");
            exit();
        } else {
            // Mensagem de erro se o tipo de arquivo não for permitido
            echo "Tipo de arquivo inválido! Apenas imagens JPG, JPEG, PNG e GIF são permitidas.";
        }
    }
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
        }

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
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    
    <div class="row justify-content-center mb-4">
        <div class="col-md-3 text-center">
            <!-- Exibe a foto do usuário -->
            <?php if ($user['Foto']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user['Foto']); ?>" alt="Foto do Usuário" class="img-fluid rounded-circle profile-pic">
            <?php else: ?>
                <img src="imagens/Fundo de Autônomo (Sem passar o mouse).png" alt="Foto do Usuário" class="img-fluid rounded-circle profile-pic">
            <?php endif; ?>
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

    <!-- Formulário para upload de foto -->
    <form action="" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="foto">Alterar Foto:</label>
            <input type="file" name="foto" id="foto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Enviar Foto</button>
    </form>

    <div class="d-flex justify-content-center mt-4">
        <a href="EditarAutonomo.php" class="btn btn-primary btn-lg rounded-pill">Editar Perfil</a>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
