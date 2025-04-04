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
    <link rel="stylesheet" href="estilos.css">
   
</head>
<body>

<div class="container">
    <h2>Autônomos</h2>
    <input type="text" id="search" placeholder="Procurar...">

    <div class="lista-autonomos">
        <?php foreach ($autonomo as $autonomo) : ?>
            <div class="card">
                <img src="foto">
                <div class="info">
                    <h3><?= strtoupper($nome['nome']) ?></h3>
                    <p><?= $prof['profissao'] ?></p>
                    <small><?= $dis['disponibilidade'] ?></small>
                </div>
                <button class="favorito" style="color: <?= $autonomo['favorito'] ? 'red' : 'gray' ?>">&#x2764;</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
