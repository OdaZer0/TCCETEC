<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css"> 
    <link rel="stylesheet" href="estilos2.css">
    <link rel="stylesheet" href="estilos3.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>
        .custom-font {
            color: #18486b;
            padding-top: 3%;
            font-family: 'Poppins', sans-serif;
        }
        .cardimgsize {
            width: 100%;
            height: auto;
        }
        .cardshadow {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>
 <a href="Cadastro_Adm.html">cadastro adm fodaaaaaa</a>
    <div class="container text-center custom-font">
        <h1>ANTES DE IR PARA A TELA INICIAL</h1>
        <p style="color: gray;">Gostaria de entrar como Usuário ou Autônomo</p>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            
            <div class="col-md-6 col-lg-5 mb-4">
                <div class="card cardshadow">
                    <div class="row g-0">
                        <div class="col-12 text-center" style="background-color: orange;">
                            <img src="https://findes.com.br/wp-content/uploads/2021/03/Foto-Beneficios_450x300px.png" class="cardimgsize" alt="Autônomo">
                        </div>
                        <div class="col-12 text-center p-3" style="background-color: rgb(255, 187, 0);">
                            <h3 style="color: white;">Autônomo</h3>
                            <a href="cadastro_autonomo.php" class="btn btn-outline-light">Ir para o cadastro</a>
                            <a href="LoginAutonomefront.php" class="btn btn-outline-light">Ir para o login</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-5 mb-4">
                <div class="card cardshadow">
                    <div class="row g-0">
                        <div class="col-12 text-center" style="background-color: orange;">
                            <img src="https://wesco.com.br/wp-content/uploads/2015/08/Pessoas-felizes.jpg" class="cardimgsize" alt="Usuário">
                        </div>
                        <div class="col-12 text-center p-3" style="background-color: #18486b;">
                            <h3 style="color: white;">Usuário</h3>
                            <a href="cadastro_user.php" class="btn btn-outline-light">Ir para o cadastro</a>
                            <a href="LoginUserFront.php" class="btn btn-outline-light">Ir para o login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>