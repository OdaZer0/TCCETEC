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

            $query = $pdo->prepare("UPDATE Autonomo SET Foto = :foto WHERE Id = :id");
            $query->bindParam(':foto', $imagemConteudo, PDO::PARAM_LOB);
            $query->bindParam(':id', $_SESSION['usuario_id']);
            $query->execute();

            header("Location: PerfilAutonomo.php");
            exit();
        } else {
            echo "Tipo de arquivo inválido! Apenas JPG, JPEG, PNG e GIF são permitidos.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">

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
            max-width: 150px;
            max-height: 150px;
            width: auto;
            height: auto;
            border-radius: 50%;
            object-fit: contain;
            background-color: #fff;
            border: 5px solid #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .profile-table {
            background-color: #696969;
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

        .btn-primary:focus,
        .btn-primary:active {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">

    <div class="row justify-content-center mb-4">
        <div class="col-md-3 text-center">
            <?php if ($user['Foto']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user['Foto']); ?>" alt="Foto do Usuário" class="rounded-circle profile-pic">
            <?php else: ?>
                <img src="imagens/Fundo de Autônomo (Sem passar o mouse).png" alt="Foto do Usuário" class="rounded-circle profile-pic">
            <?php endif; ?>
        </div>
        <div class="col-md-9 d-flex align-items-center justify-content-center">
            <h2 class="text-center custom-font mb-0">Perfil do Autônomo</h2>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped profile-table">
            <tbody>
                <tr><th class="table-light">Nome:</th><td><?php echo htmlspecialchars($user['Nome']); ?></td></tr>
                <tr><th class="table-light">Email:</th><td><?php echo htmlspecialchars($user['Email']); ?></td></tr>
                <tr><th class="table-light">CR:</th><td><?php echo htmlspecialchars($user['CR']); ?></td></tr>
                <tr><th class="table-light">CEP:</th><td><?php echo htmlspecialchars($user['Cep']); ?></td></tr>
                <tr><th class="table-light">Área de Atuação:</th><td><?php echo htmlspecialchars($user['AreaAtuacao']); ?></td></tr>
                <tr><th class="table-light">Nível de Formação:</th><td><?php echo htmlspecialchars($user['NivelFormacao']); ?></td></tr>
            </tbody>
        </table>
    </div>

    <!-- Formulário de upload -->
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
    <div class="d-flex justify-content-center mt-4">
        <a href="Tela_Autonomo.html" class="btn btn-primary btn-lg rounded-pill">Voltar</a>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
