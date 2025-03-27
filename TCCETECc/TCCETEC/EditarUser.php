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

// Lidar com o envio do formulário de edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome');
    $email = filter_input(INPUT_POST, 'email');
    $cep = filter_input(INPUT_POST, 'cep');

    // Atualizar informações do usuário
    $updateQuery = $pdo->prepare("UPDATE Usuario SET Nome = :nome, Email = :email,  Cep = :cep WHERE Id = :id");
    $updateQuery->bindParam(':nome', $nome);
    $updateQuery->bindParam(':email', $email);
    $updateQuery->bindParam(':cep', $cep);
    $updateQuery->bindParam(':id', $_SESSION['usuario_id']);
    $updateQuery->execute();

    // Redirecionar para o perfil atualizado
    header("Location: PerfilUser.php");
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
    <title>Editar Perfil</title>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2 class="d-flex custom-font justify-content-center">Editar Perfil</h2>
    <form action="EditarUser.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nome:</label>
                    <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($user['Nome']); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                </div>
            </div>
        </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">CEP:</label>
                    <input type="text" name="cep" class="form-control" value="<?php echo htmlspecialchars($user['Cep']); ?>" required>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-success">Salvar Alterações</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
