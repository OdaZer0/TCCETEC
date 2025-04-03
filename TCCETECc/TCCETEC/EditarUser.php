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
    <style>
    /* Estilo da fonte personalizada */
.custom-font {
    font-family: 'Arial', sans-serif;
    font-weight: 600;
    color: #343a40;
}

/* Container centralizado com margem superior */
.container {
    max-width: 900px;
    padding-top: 50px;
    padding-bottom: 50px;
}

/* Estilo do card para destacar o formulário */
.card {
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

/* Estilo do corpo do card */
.card-body {
    padding: 30px;
}

/* Estilo dos campos de formulário */
.form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 15px;
    font-size: 1.1rem;
}

/* Aumentando o tamanho dos campos */
.form-control-lg {
    height: 50px;
}

/* Estilo do botão */
.btn-primary {
    background-color: #007bff; /* Azul claro */
    border-color: #007bff;
    color: white;
    font-size: 1.2rem;
    font-weight: bold;
    border-radius: 50px;
    padding: 15px 30px;
    transition: background-color 0.3s ease;
}

/* Efeito de hover no botão */
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* Estilo do botão ao focar */
.btn-primary:focus, .btn-primary:active {
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
}

/* Tamanho da tabela */
.table {
    font-size: 1rem;
}

/* Margem para o título */
.mb-5 {
    margin-bottom: 3rem !important;
}

.mb-4 {
    margin-bottom: 2rem !important;
}
 </style>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center custom-font mb-5">Editar Perfil</h2>
    <div class="card shadow-lg rounded">
        <div class="card-body">
            <form action="EditarUser.php" method="POST">
                <div class="row mb-4">
                    <!-- Campo Nome -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nome:</label>
                            <input type="text" name="nome" class="form-control form-control-lg" value="<?php echo htmlspecialchars($user['Nome']); ?>" required>
                        </div>
                    </div>
                    <!-- Campo Email -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control form-control-lg" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <!-- Campo CEP -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">CEP:</label>
                            <input type="text" name="cep" class="form-control form-control-lg" value="<?php echo htmlspecialchars($user['Cep']); ?>" required>
                        </div>
                    </div>
                </div>

                <!-- Botão de Salvar Alterações -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
