<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimento</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fb;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            font-size: 2.2rem;
            color: #3498db;
            margin-bottom: 20px;
            font-weight: 600;
        }

        img {
            width: 100px;
            margin: 20px 0;
        }

        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 30px;
            transition: background-color 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 1.8rem;
            }

            .btn {
                font-size: 1.1rem;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>AGRADECEMOS A SUA AVALIAÇÃO!</h1>
        <img src="https://cdn-icons-png.flaticon.com/512/742/742751.png" alt="Ícone de agradecimento">
        <p style="font-size: 1.1rem; color: #7f8c8d;">Sua opinião é muito importante para nós e nos ajuda a melhorar cada vez mais.</p>
        <br>
        <a href="avaliacao.php"><button class="btn">FECHAR</button></a>
    </div>

</body>
</html>
