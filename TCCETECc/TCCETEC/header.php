<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: white;
            padding: 15px 20px;
            border-bottom: 2px solid #ddd;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {

            width: 120px;
            height: auto;
        }
        .nav {
            display: flex;
            gap: 20px;
            font-weight: bold;
        }
        .nav a {
            text-decoration: none;
            color: black;
        }
        .nav a:hover {
            color: gray;
        }
        .profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="Imagens/automatizac.png" alt="AutoMatiza">
        </div>
        <nav class="nav">
            <a href="#">MENU PRINCIPAL</a> |
            <a href="#">AUTÔNOMOS</a> |
            <a href="#">FAVORITOS</a>
        </nav>
        <div>
            <img src="https://e7.pngegg.com/pngimages/722/101/png-clipart-computer-icons-user-profile-circle-abstract-miscellaneous-rim.png" alt="Perfil" class="profile">
        </div>
    </header>
</body>
</html>
