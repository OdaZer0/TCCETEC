<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = Conexao::getConexao();

$query = $pdo->prepare("SELECT * FROM Autonomo WHERE Id = :Id");
$query->bindParam(':Id', $_SESSION['usuario_id']);
$query->execute();
$user = $query->fetch();

if (!$user) {
    header("Location: login.php");
    exit();
}

// Lógica de upload de foto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];

    if ($foto['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $tiposPermitidos)) {
            list($larguraOriginal, $alturaOriginal) = getimagesize($foto['tmp_name']);
            $tamanhoMaximo = 300;

            if ($larguraOriginal > $alturaOriginal) {
                $novaLargura = $tamanhoMaximo;
                $novaAltura = intval($alturaOriginal * $tamanhoMaximo / $larguraOriginal);
            } else {
                $novaAltura = $tamanhoMaximo;
                $novaLargura = intval($larguraOriginal * $tamanhoMaximo / $alturaOriginal);
            }

            $imagemRedimensionada = imagecreatetruecolor($novaLargura, $novaAltura);

            switch ($extensao) {
                case 'jpg':
                case 'jpeg':
                    $origem = imagecreatefromjpeg($foto['tmp_name']);
                    break;
                case 'png':
                    $origem = imagecreatefrompng($foto['tmp_name']);
                    imagealphablending($imagemRedimensionada, false);
                    imagesavealpha($imagemRedimensionada, true);
                    break;
                case 'gif':
                    $origem = imagecreatefromgif($foto['tmp_name']);
                    break;
                default:
                    echo "Formato de imagem não suportado.";
                    exit();
            }

            imagecopyresampled($imagemRedimensionada, $origem, 0, 0, 0, 0, $novaLargura, $novaAltura, $larguraOriginal, $alturaOriginal);

            ob_start();
            imagejpeg($imagemRedimensionada);
            $imagemConteudo = ob_get_clean();

            imagedestroy($imagemRedimensionada);
            imagedestroy($origem);

            // Atualiza a foto no banco de dados
            $query = $pdo->prepare("UPDATE Autonomo SET Foto = :foto WHERE Id = :id");
            $query->bindParam(':foto', $imagemConteudo, PDO::PARAM_LOB);
            $query->bindParam(':id', $_SESSION['usuario_id']);
            $query->execute();

            // Exibe uma mensagem de sucesso
            $successMessage = "Foto alterada com sucesso!";
        } else {
            $errorMessage = "Tipo de arquivo inválido! Apenas JPG, JPEG, PNG e GIF são permitidos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuário</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">

    <style>
        /* Resetando margens e padding para garantir consistência */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilo do corpo e fontes */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            padding-top: 70px;
            color: #555;
        }

        /* Estilo do container principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .custom-font {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #343a40;
            font-size: 36px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Foto de perfil com borda arredondada e hover effect */
        .profile-pic {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Estilo para a tabela de informações do perfil */
        .profile-table th {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 10px;
        }

        .profile-table td {
            padding: 15px;
            font-size: 18px;
            color: #333;
            background-color: #f9f9f9;
        }

        .profile-table {
            margin-top: 30px;
            border-radius: 10px;
            border-collapse: collapse;
        }

        /* Estilo dos botões */
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 15px 25px;
            font-size: 18px;
            border-radius: 50px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            color: #fff;
            padding: 15px 25px;
            font-size: 18px;
            border-radius: 50px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        /* Formatação do formulário de envio de foto */
        .form-group label {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
        }

        .form-control {
            border: 2px solid #ddd;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
        }

        /* Mensagens de feedback (sucesso ou erro) */
        .alert-success {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 18px;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 18px;
        }

        /* Estilo responsivo */
        @media (max-width: 767px) {
            .profile-pic {
                width: 150px;
                height: 150px;
            }

            .container {
                padding: 20px;
            }

            .custom-font {
                font-size: 28px;
            }

            .btn-primary, .btn-secondary {
                padding: 12px 22px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="container">

    <!-- Foto de Perfil e Cabeçalho -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-3 text-center">
            <?php if ($user['Foto']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user['Foto']); ?>" alt="Foto do Usuário" class="rounded-circle profile-pic">
            <?php else: ?>
                <img src="imagens/Fundo de Autônomo (Sem passar o mouse).png" alt="Foto do Usuário" class="rounded-circle profile-pic">
            <?php endif; ?>
        </div>
        <div class="col-md-9 d-flex align-items-center justify-content-center">
            <h2 class="custom-font">Perfil de Autônomo</h2>
        </div>
    </div>

    <!-- Mensagens de Sucesso ou Erro -->
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Tabela de Informações do Perfil -->
    <div class="table-responsive">
        <table class="table profile-table">
            <tbody>
                <tr><th>Nome:</th><td><?php echo htmlspecialchars($user['Nome']); ?></td></tr>
                <tr><th>Email:</th><td><?php echo htmlspecialchars($user['Email']); ?></td></tr>
                <tr><th>CR:</th><td><?php echo htmlspecialchars($user['CR']); ?></td></tr>
                <tr><th>CEP:</th><td><?php echo htmlspecialchars($user['Cep']); ?></td></tr>
                <tr><th>Área de Atuação:</th><td><?php echo htmlspecialchars($user['AreaAtuacao']); ?></td></tr>
                <tr><th>Nível de Formação:</th><td><?php echo htmlspecialchars($user['NivelFormacao']); ?></td></tr>
            </tbody>
        </table>
    </div>

    <!-- Formulário de upload de foto -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="foto">Alterar Foto:</label>
            <input type="file" name="foto" id="foto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Enviar Foto</button>
    </form>

    <!-- Botões de ação -->
    <div class="d-flex justify-content-center mt-4">
        <a href="EditarAutonomo.php" class="btn btn-primary">Editar Perfil</a>
        <a href="Tela_Autonomo.html" class="btn btn-secondary ml-3">Voltar</a>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
