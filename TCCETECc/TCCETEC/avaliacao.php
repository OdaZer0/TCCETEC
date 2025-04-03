<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .stars {
            display: flex;
            justify-content: center;
        }
        .star {
            font-size: 30px;
            cursor: pointer;
            color: gray;
        }
        .star.selected {
            color: gold;
        }
        textarea {
            width: 50%;
            height: 50px;
            margin-top: 10px;
        }
        button {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
    <h1>Avaliação</h1>
    <p>O que está achando do nosso serviço?</p>
    <div class="stars">
        <span class="star" data-value="1">★</span>
        <span class="star" data-value="2">★</span>
        <span class="star" data-value="3">★</span>
        <span class="star" data-value="4">★</span>
        <span class="star" data-value="5">★</span>
    </div>

    <form action="salvar.php" method="POST">
        <input type="hidden" name="estrelas" id="estrelas" value="0">
        <textarea name="comentario" placeholder="Comentário..."></textarea><br>
        <button type="submit">ENVIAR</button>
    </form>

    <script>
        let stars = document.querySelectorAll('.star');
        let estrelasInput = document.getElementById('estrelas');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                let value = this.getAttribute('data-value');
                estrelasInput.value = value;

                stars.forEach(s => s.classList.remove('selected'));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });
    </script>



</body>
</html>
