<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilos.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos3.css">
</head>

<body>
    <?php include "menu.php" ?>
    <div class="container">
        <form name="Usercadform" action="../backend/usuarios/cadastrarautonomo.php" class="form" method="POST" enctype="multipart/form-data"> 
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
               
                <div class="col-md-12">
                    <label class="form-label">Confirmar Senha:</label>
                    <input type="password" name="senhac" class="form-control" maxlength="250" required>
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
                    <label class="form-label">Área de Atuação:</label>
                    <input type="text" name="area_atuacao" class="form-control" maxlength="20" required>
                </div>
            </div>
            <div class="row">
               
                <div class="col-md-12">
                    <label class="form-label">Nível de Formação:</label>
                    <input type="text" name="nivel_formacao" class="form-control" maxlength="20" required>
                </div>

            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btna btn-outline-info me-2">Cadastrar</button>
                    <button type="reset" class="btn btna btn-outline-danger">Reiniciar</button>
                </div>
            </div>
        </form>

        <?php

$host = 'root'; 
$dbname = 'automatiza'; 
$user = '';
$password = ''; 

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $nome = $_POST['Nome'];
    $email = $_POST['Email'];
    $senha = password_hash($_POST['Senha'], PASSWORD_BCRYPT);
    $cpf = $_POST['Cpf'];
    $cep = $_POST['Cep'];
    $areaAtuacao = $_POST['AreaAtuacao'];
    $nivelFormacao = $_POST['NivelFormacao'];

   
    $sql = "INSERT INTO usuarios (Id, Nome, Email, Senha, Cpf, Cep, AreaAtuacao, NivelFormacao) VALUES (NULL, :nome, :email, :senha, :cpf, :cep, :areaAtuacao, :nivelFormacao)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':areaAtuacao', $areaAtuacao);
        $stmt->bindParam(':nivelFormacao', $nivelFormacao);
        $stmt->execute();

        echo "Usuário cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
}
?>

    <?php include "footer.php" ?>
</body>

</html>
