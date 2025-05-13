<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha seu Perfil</title>

    <!-- Bootstrap 5.3 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Estilos locais -->
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="estilos2.css">
    <link rel="stylesheet" href="estilos3.css">

    <style>
        :root {
            --azul-escuro: #18486b;
            --laranja: #ffbb00;
            --cinza-claro: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cinza-claro);
        }

        .custom-title {
            color: var(--azul-escuro);
            font-weight: 700;
            margin-top: 50px;
        }

        .custom-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }

        .card-role {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-role:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 230px;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .btn-custom {
            margin: 5px;
            width: 140px;
            transition: all 0.2s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.05);
        }

        .footer-space {
            margin-bottom: 60px;
        }

        @media (max-width: 767px) {
            .card-img-top {
                height: 180px;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Conteúdo -->
    <div class="container text-center">
        <h1 class="custom-title">Escolha como deseja continuar</h1>
        <p class="custom-subtitle">Você quer se cadastrar como um Autônomo ou como Usuário?</p>

        <div class="row justify-content-center">
            <!-- Card Autônomo -->
            <div class="col-md-6 col-lg-5 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card card-role shadow-sm">
                    <img src="https://findes.com.br/wp-content/uploads/2021/03/Foto-Beneficios_450x300px.png" alt="Autônomo" class="card-img-top">
                    <div class="card-body text-center bg-warning text-white">
                        <h3 class="card-title"><i class="bi bi-tools me-2"></i>Autônomo</h3>
                        <a href="cadastro_autonomo.php" class="btn btn-outline-light btn-custom">Cadastro</a>
                        <a href="LoginAutonomefront.php" class="btn btn-outline-light btn-custom">Login</a>
                    </div>
                </div>
            </div>

            <!-- Card Usuário -->
            <div class="col-md-6 col-lg-5 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card card-role shadow-sm">
                    <img src="https://wesco.com.br/wp-content/uploads/2015/08/Pessoas-felizes.jpg" alt="Usuário" class="card-img-top">
                    <div class="card-body text-center" style="background-color: var(--azul-escuro); color: white;">
                        <h3 class="card-title"><i class="bi bi-person-circle me-2"></i>Usuário</h3>
                        <a href="cadastro_user.php" class="btn btn-outline-light btn-custom">Cadastro</a>
                        <a href="LoginUserFront.php" class="btn btn-outline-light btn-custom">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer-space"></div>
    <?php include 'footer.php'; ?>

    <!-- Inicializa animações -->
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>

</html>
