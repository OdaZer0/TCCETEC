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
            background-color: #f8f9fa;
        }

        /* Header Container */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            padding: 15px 20px;
            border-bottom: 2px solid #ddd;
        }

        /* Logo Section */
        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 120px;
            height: auto;
        }

        /* Navigation Menu */
        .nav {
            display: flex;
            gap: 20px;
            font-weight: bold;
        }

        .nav a {
            text-decoration: none;
            color: black;
            transition: color 0.3s ease;
        }

        .nav a:hover {
            color: #007bff;
        }

        /* Profile Section */
        .profile-container {
            position: relative;
        }

        .profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .profile:hover {
            transform: scale(1.1);
        }

        /* Dropdown Menu for Profile */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 200px;
            z-index: 10;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background-color: #f8f9fa;
        }

        /* Show the dropdown menu when hovering over profile */
        .profile-container:hover .dropdown-menu {
            display: block;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                gap: 10px;
            }

            .header {
                flex-direction: column;
                align-items: center;
            }

            .profile-container {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <!-- Logo Section -->
        <div class="logo">
            <img src="Imagens/automatizac.png" alt="AutoMatiza">
        </div>

        <!-- Navigation Menu -->
        <nav class="nav">
            <a href="telahome.php">MENU PRINCIPAL</a>
            <a href="#">AUTÔNOMOS</a>
            <a href="#">FAVORITOS</a>
        </nav>

        <!-- Profile Section with Dropdown -->
        <div class="profile-container">
            <img src="https://e7.pngegg.com/pngimages/722/101/png-clipart-computer-icons-user-profile-circle-abstract-miscellaneous-rim.png" alt="Perfil" class="profile">
            <!-- Dropdown Menu -->
            <div class="dropdown-menu">
                <a href="Telainiciocadastro.php">Cadastro e Login</a>
                <a href="logout.php">Sair</a>
            </div>
        </div>
    </header>

</body>
</html>
