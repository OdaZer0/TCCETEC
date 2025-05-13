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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">

    <style>
        /* Fonte padrão */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #e0e0e0, #ffffff);
            color: #495057;
            padding-top: 60px;
        }

        .container {
            max-width: 1200px;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .custom-font {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #343a40;
            font-size: 36px;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Fotografia de perfil */
        .profile-pic {
            max-width: 170px;
            max-height: 170px;
            width: auto;
            height: auto;
            border-radius: 50%;
            object-fit: cover;
            background-color: #fff;
            border: 4px solid #f8f9fa;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Tabelas de perfil */
        .profile-table {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .profile-table th {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .profile-table td {
            background-color: #ffffff;
            color: #495057;
            border-bottom: 1px solid #f1f1f1;
        }

        /* Botões */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 16px 35px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 50px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-primary:focus,
        .btn-primary:active {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            padding: 16px 35px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 50px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        /* Formulário de upload */
        .form-control {
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(38, 143, 255, 0.3);
        }

        /* Responsividade */
        @media (max-width: 767px) {
            .profile-pic {
                max-width: 140px;
                max-height: 140px;
            }

            .container {
                padding: 20px;
            }

            .custom-font {
                font-size: 28px;
            }

            .btn-primary, .btn-secondary {
                padding: 12px 28px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">

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
            <h2 class="text-center custom-font mb-0">Perfil do Autônomo</h2>
        </div>
    </div>

    <!-- Tabela de Informações do Perfil -->
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

    <!-- Formulário de upload de foto -->
    <form action="" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="foto">Alterar Foto:</label>
            <input type="file" name="foto" id="foto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Enviar Foto</button>
    </form>

    <!-- Botões de Ação -->
    <div class="d-flex justify-content-center mt-4">
        <a href="EditarAutonomo.php" class="btn btn-primary btn-lg rounded-pill">Editar Perfil</a>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <a href="Tela_Autonomo.html" class="


O ChatGPT disse:
btn btn-secondary btn-lg rounded-pill">Voltar</a>
</div>

</div> <?php include 'footer.php'; ?> </body> </html> ```