<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTOMATIZA</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css"> 
    <link rel="stylesheet" href="estilos2.css">
    <link rel="stylesheet" href="estilos3.css">
    <link rel="stylesheet" href="mudar.js">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <style>
        .carousel img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.trabalho img {
    width: 200px;
    height: 150px;
    border-radius: 10px;
    display: block;
    margin: 0 auto;
}
.carousel-container {
    position: relative;
    width: 80%;
    margin: auto;
    overflow: hidden;
    border-radius: 10px;
}

.carousel {
    display: flex;
    width: 300%;
    transition: transform 0.5s ease-in-out;
}

.carousel img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.prev, .next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    font-size: 18px;
    border-radius: 5px;
}

.prev { left: 10px; }
.next { right: 10px; }

.prev:hover, .next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.trabalhos-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.trabalho {
    text-align: center;
}

.trabalho img {
    width: 200px;
    height: 150px;
    border-radius: 10px;
    display: block;
    margin: auto;
}

.prev-trabalho, .next-trabalho {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    font-size: 18px;
    border-radius: 5px;
}

.prev-trabalho:hover, .next-trabalho:hover {
    background-color: rgba(0, 0, 0, 0.8);
}



        </style>
<?php include 'header.php'; ?>
    
    <section class="carrossel">
    <div class="carousel">
    <img src="https://img.freepik.com/fotos-gratis/amigos-durante-a-sessao-de-estudo-aprendendo-e-mostrando-o-sinal-de-paz_23-2149265835.jpg" alt="Banner 1">
    <img src="https://img.freepik.com/fotos-gratis/agencia-de-marketing-autentica-pequena-e-jovem_23-2150167428.jpg" alt="Banner 2">
    <img src="https://s2.glbimg.com/ZWug4OZLEmAvSlfciXTOx9c-Ukw=/e.glbimg.com/og/ed/f/original/2014/08/21/empreendedores-felizes.jpg" alt="Banner 3">
</div>
<button class="prev" onclick="mudarSlide(-1)">&#10094;</button>
    <button class="next" onclick="mudarSlide(1)">&#10095;</button>
</div>

        </div>
    </section>
    
    <div class="search-container">
        <input type="text" placeholder="Procurar...">
        <button>🔍</button>
    </div>

    <<h2>Os trabalhos mais buscados</h2>
<div class="trabalhos-container">
    <button class="prev-trabalho" onclick="mudarTrabalho(-1)">&#10094;</button>

    <div class="trabalho">
        <img src="https://themosvagas.com.br/wp-content/uploads/2017/11/cozinheiro-a-1471616524.jpg" alt="Cozinheiro">
        <p>Cozinheiro para Festas</p>
    </div>

    <div class="trabalho">
        <img src="https://i0.wp.com/blog.mundomidia.com/wp-content/uploads/2018/06/como-contratar-um-bom-mecanico.jpg?fit=1200%2C1200&ssl=1" alt="Mecânico">
        <p>Mecânico</p>
    </div>

    <div class="trabalho">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKzU1oNwm8gMhzRqxJJv3C0whJ9rHHDdGCgQ&s" alt="Pintura">
        <p>Pintura Interior</p>
    </div>

    <button class="next-trabalho" onclick="mudarTrabalho(1)">&#10095;</button>
</div>

    
<?php include 'footer.php'; ?>
</body>
</html>