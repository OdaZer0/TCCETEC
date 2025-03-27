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
$query = $pdo->prepare("SELECT * FROM Usuario WHERE Id = :id");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">
    <title>Perfil de Usuário</title>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2 class="d-flex custom-font justify-content-center">Perfil do Usuário</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Nome']); ?>" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">CR:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['CR']); ?>" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">CEP:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['Cep']); ?>" disabled>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <a href="EditarUser.php" class="btn btn-outline-warning">Editar Perfil</a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
