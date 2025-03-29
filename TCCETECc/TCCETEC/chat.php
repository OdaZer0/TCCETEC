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

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat PHP e MySQL</title>
    <style>
        /* Estilos básicos */
        body {
            font-family: Arial, sans-serif;
        }
        #chat {
            width: 400px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }
        #mensagens {
            height: 300px;
            overflow-y: scroll;
            border-bottom: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
        }
        #input-mensagem {
            width: 100%;
            padding: 10px;
        }
    </style>
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

<?php include 'footer.php'; ?>


</body>
</html>
