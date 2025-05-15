<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrate Autônomos - Página Inicial</title>

    <!-- Link para o Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Estilo Customizado -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }

        .navbar-nav .nav-link:hover {
            color: #f8f9fa !important;
        }

        .hero-section {
            background-color: #007bff;
            color: white;
            padding: 50px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
        }

        .search-section {
            margin: 40px 0;
            text-align: center;
        }

        .search-section input {
            width: 60%;
            padding: 10px;
            font-size: 1.2rem;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .search-section button {
            padding: 10px 20px;
            font-size: 1.2rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-section button:hover {
            background-color: #0056b3;
        }

        .autonomos-section {
            margin: 50px 0;
        }

        .autonomo-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            transition: transform 0.3s;
        }

        .autonomo-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .autonomo-card img {
            width: 100%;
            border-radius: 10px;
        }

        .autonomo-card h5 {
            margin-top: 15px;
            font-size: 1.5rem;
            color: #333;
        }

        .autonomo-card p {
            font-size: 1rem;
            color: #666;
            margin-top: 10px;
        }

        .autonomo-card .rating {
            margin-top: 10px;
        }

        .autonomo-card .rating i {
            color: #ffc107;
        }

        .autonomo-card .btn-contratar {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            width: 100%;
            font-size: 1.1rem;
            margin-top: 15px;
            cursor: pointer;
        }

        .autonomo-card .btn-contratar:hover {
            background-color: #218838;
        }

        .footer {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .footer p {
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .search-section input {
                width: 80%;
                margin-right: 0;
            }
        }

    </style>
</head>

<body>

    
   <<?php include 'header.php'; ?>

    <!-- Seção Hero -->
    <section class="hero-section">
        <div class="container">
            <h1>Encontre o Melhor Profissional para o Seu Serviço</h1>
            <p>Explore uma variedade de autônomos qualificados para atender às suas necessidades</p>
        </div>
    </section>

    <!-- Seção de Busca -->
    <section class="search-section">
        <div class="container">
            <input type="text" placeholder="Pesquise por categoria ou profissional...">
            <button>Pesquisar</button>
        </div>
    </section>

    <!-- Seção de Autônomos -->
    <section class="autonomos-section">
        <div class="container">
            <h2>Autônomos Disponíveis</h2>
            <div class="row">
                <!-- Card de Autônomo -->
                <div class="col-md-4">
                    <div class="autonomo-card">
                        <img src="https://via.placeholder.com/350x250" alt="Autônomo 1">
                        <h5>João Silva</h5>
                        <p>Especialista em Design Gráfico. Criação de logos, banners, e materiais gráficos.</p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <button class="btn-contratar">Contratar</button>
                    </div>
                </div>
                <!-- Card de Autônomo -->
                <div class="col-md-4">
                    <div class="autonomo-card">
                        <img src="https://via.placeholder.com/350x250" alt="Autônomo 2">
                        <h5>Maria Oliveira</h5>
                        <p>Consultora de Marketing Digital. Estratégias de SEO, Google Ads e redes sociais.</p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <button class="btn-contratar">Contratar</button>
                    </div>
                </div>
                <!-- Card de Autônomo -->
                <div class="col-md-4">
                    <div class="autonomo-card">
                        <img src="https://via.placeholder.com/350x250" alt="Autônomo 3">
                        <h5>Ana Souza</h5>
                        <p>Desenvolvedora Full Stack. Criação de websites e aplicações web.</p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <button class="btn-contratar">Contratar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <<?php include 'footer.php'; ?>
    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
