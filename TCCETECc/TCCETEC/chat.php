<?php
include 'conexao2.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $usuario = $_POST['usuario'];
    $mensagem = $_POST['mensagem'];

    
    $sql = "INSERT INTO mensagens (usuario, mensagem) VALUES (:usuario, :mensagem)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':mensagem', $mensagem);
    $stmt->execute();
}
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat PHP e MySQL</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(45deg, #ff6f61,rgb(0, 162, 255),rgb(255, 123, 0));
    background-size: 400% 400%; 
    animation: gradientAnimation 10s ease infinite; 
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}


        #chat {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
            border: 1px solid #ddd;
        }

        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        #mensagens {
            height: 300px;
            overflow-y: scroll;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        #mensagens p {
            background-color: #e1f5fe;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            color: #333;
            font-size: 14px;
            max-width: 80%;
        }

        #mensagens p strong {
            font-weight: bold;
            color: #007bff;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], textarea {
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #007bff;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .input-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .input-container input {
            flex-grow: 1;
        }

        /* Animação suave de rolagem */
        #mensagens p {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

    </style>
</head>
</head>
<body>

<div id="chat">
    <h3>Chat em Tempo Real</h3>
    <div id="mensagens">
        <?php
        
        $sql = "SELECT * FROM mensagens ORDER BY data_envio ASC";
        $stmt = $pdo->query($sql);
        while ($mensagem = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<p><strong>{$mensagem['usuario']}:</strong> {$mensagem['mensagem']}</p>";
        }
        ?>
    </div>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Seu nome" required><br><br>
        <textarea name="mensagem" id="input-mensagem" placeholder="Digite sua mensagem..." required></textarea><br>
        <button type="submit">Enviar</button>
    </form>
</div>




</body>
</html>
