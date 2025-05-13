<?php
include 'header.php';

$autonomos = [
    [
        "nome" => "Isabela Nogueira",
        "foto" => "isabela.jpg",
        "profissao" => "Fotógrafa de Lifestyle e Eventos",
        "disponibilidade" => "Segunda à Sábados (Presencial)",
        "favorito" => false
    ],
    [
        "nome" => "Camila Duarte",
        "foto" => "camila.jpg",
        "profissao" => "Personal Organizer",
        "disponibilidade" => "Segunda à Sexta (Presencial) e Sábados (Online)",
        "favorito" => true
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Autônomos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu&display=swap" rel="stylesheet">
    
    <style>
        /* Estilo personalizado */
        body {
            font-family: 'Baloo Tammudu', cursive;
            background-color: #f4f7fc;
            padding-top: 20px;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            color: #343a40;
        }

        .lista-autonomos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .info {
            padding: 15px;
        }

        .info h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #343a40;
        }

        .info p {
            font-size: 1rem;
            color: #6c757d;
        }

        .info small {
            font-size: 0.9rem;
            color: #28a745;
        }

        .favorito {
            font-size: 1.5rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .favorito.favorito-ativo {
            color: #ff6b6b;
        }

        #search {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Lista de Autônomos</h2>
        <input type="text" id="search" placeholder="Procurar...">
        
        <div class="lista-autonomos" id="autonomos-lista">
            <?php foreach ($autonomos as $autonomo) : ?>
                <div class="card" data-nome="<?= strtolower($autonomo['nome']); ?>" data-profissao="<?= strtolower($autonomo['profissao']); ?>">
                    <img src="<?= $autonomo['foto']; ?>" alt="<?= $autonomo['nome']; ?>">
                    <div class="info">
                        <h3><?= strtoupper($autonomo['nome']); ?></h3>
                        <p><?= $autonomo['profissao']; ?></p>
                        <small><?= $autonomo['disponibilidade']; ?></small>
                    </div>
                    <button class="favorito <?= $autonomo['favorito'] ? 'favorito-ativo' : ''; ?>" onclick="toggleFavorito(this)">
                        &#x2764;
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Função para filtrar a lista com base no input de pesquisa
        document.getElementById('search').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                let nome = card.getAttribute('data-nome');
                let profissao = card.getAttribute('data-profissao');
                if (nome.includes(filter) || profissao.includes(filter)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Função para alternar a classe de favorito
        function toggleFavorito(button) {
            button.classList.toggle('favorito-ativo');
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
