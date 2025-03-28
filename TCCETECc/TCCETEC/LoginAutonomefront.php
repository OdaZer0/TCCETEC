<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
    <title>Login</title>

    <style>
        /* Estilização do container com a imagem de fundo */
        .container {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('imagens/Fundo de Autônomo (Sem passar o mouse).png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color:; /* Garante visibilidade do texto */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); /* Efeito de sombra */
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

    <div class="container">
        <form name="loginForm" action="login.php" method="POST" class="form">
            <h2 class="d-flex custom-font justify-content-center">Login</h2>
            
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Usuário:</label>
                    <input type="text" name="usuario" class="form-control" maxlength="50" required>
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
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btna btn-outline-info me-2">Entrar</button>
                        <button type="reset" class="btn btna btn-outline-danger">Reiniciar</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

<?php include 'footer.php'; ?>

</body>
</html>
