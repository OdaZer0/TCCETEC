<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu&display=swap" rel="stylesheet">
</head>

<body>
    <?php include "menu.php" ?>
    <div class="container">
        <form name="Usercadform" action="cadastrar.php" class="form" method="POST">
            <h2 class="d-flex custom-font justify-content-center">Cadastro de Autônomo</h2>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Nome:</label>
                    <input type="text" name="nome" class="form-control" maxlength="50" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" maxlength="60" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Senha:</label>
                    <input type="password" name="senha" class="form-control" maxlength="250" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">CPF:</label>
                    <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">CEP:</label>
                    <input type="text" name="cep" class="form-control" maxlength="8" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-info me-2">Cadastrar</button>
                        <button type="reset" class="btn btn-outline-danger">Reiniciar</button>
                    </div>
                </div>
            </div>
        </form>

        <?php
        $host = 'localhost'; 
        $dbname = 'automatiza'; 
        $user = 'root'; 
        $password = ''; 

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
            $cpf = $_POST['cpf'];
            $cep = $_POST['cep'];

            $sql = "INSERT INTO usuarios (Nome, Email, Senha, Cpf, Cep) VALUES (:nome, :email, :senha, :cpf, :cep)";
            
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senha);
                $stmt->bindParam(':cpf', $cpf);
                $stmt->bindParam(':cep', $cep);
                $stmt->execute();
                echo "Usuário cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar usuário: " . $e->getMessage();
            }
        }
        ?>
    </div>
    <?php include "footer.php" ?>
</body>
</html>