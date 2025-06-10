<?php
session_start();
require 'Conexao.php';
$conexao = Conexao::getConexao();

$usuarioId = $_SESSION['Id'] ?? null;

$Nome = "Usuário";
$avatarBase64 = null;

if ($usuarioId) {
    $stmt = $conexao->prepare("SELECT Nome, Foto FROM Usuario WHERE Id = ?");
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $Nome = $usuario['Nome'] ?: $Nome;

        if (!empty($usuario['Foto'])) {
            $avatarBase64 = 'data:image/jpeg;base64,' . base64_encode($usuario['Foto']);
        }
    }
}

if (!$avatarBase64) {
    $avatarBase64 = "imagens/User.png";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Usuário</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fonte Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --orange-light: #ffa94d;
            --orange-main: #ff6b00;
            --orange-dark: #e55b00;
            --gray-light: #f8f9fa;
            --gray-medium: #6c757d;
            --gray-dark: #343a40;
            --shadow-light: rgba(255, 107, 0, 0.15);
            --shadow-dark: rgba(255, 107, 0, 0.3);
        }

        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
                Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        body {
    /* Fundo com gradiente animado */
   
    animation: gradientAnimation 25s ease infinite;
    color: var(--gray-dark);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Keyframes para animação do gradiente */
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

        .navbar {
       
            backdrop-filter: saturate(180%) blur(15px);
            -webkit-backdrop-filter: saturate(180%) blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
            padding: 1rem 3rem;
            position: sticky;
            top: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 30px var(--shadow-dark);
        }
        .navbar-brand {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 2px;
            user-select: none;
            text-shadow: 0 0 12px rgba(255, 107, 0, 0.7);
        }
        .navbar a {
            color: #fff;
            font-weight: 600;
            margin-left: 2rem;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            position: relative;
        }
        .navbar a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 100%;
            height: 2px;
            background: #fff;
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        .navbar a:hover {
            color: var(--orange-light);
        }
        .navbar a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .container {
            max-width: 960px;
            margin: 3.5rem auto 5rem auto;
            padding: 0 1.5rem;
            flex-grow: 1;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }

        /* WELCOME HEADER */
        .welcome-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            background: #fff;
            border-radius: 24px;
            padding: 2rem 3rem;
            box-shadow:
                8px 8px 20px rgba(255, 107, 0, 0.07),
                -8px -8px 20px rgba(255, 255, 255, 0.7);
            transition: box-shadow 0.35s ease;
            user-select: none;
        }
        .welcome-header:hover {
            box-shadow:
                12px 12px 28px rgba(255, 107, 0, 0.12),
                -12px -12px 28px rgba(255, 255, 255, 0.85);
        }
        .welcome-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--orange-main);
            box-shadow:
                0 12px 30px var(--shadow-light),
                inset 0 0 10px var(--orange-light);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .welcome-avatar:hover {
            transform: scale(1.2);
            box-shadow:
                0 18px 40px var(--shadow-dark),
                inset 0 0 16px var(--orange-main);
        }
        .welcome-text h1 {
            font-weight: 700;
            font-size: 3rem;
            color: var(--orange-dark);
            letter-spacing: 0.04em;
            line-height: 1.1;
        }
        .welcome-text p {
            font-weight: 500;
            font-size: 1.4rem;
            color: var(--gray-medium);
            margin-top: 0.6rem;
            letter-spacing: 0.02em;
            user-select: text;
        }

        /* CARDS */
        .card {
            background: #fff;
            border-radius: 28px;
            padding: 2rem 2.5rem;
            box-shadow:
                6px 6px 16px rgba(255, 107, 0, 0.1),
                -6px -6px 16px rgba(255, 255, 255, 0.7);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: default;
            display: flex;
            flex-direction: column;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow:
                10px 10px 26px rgba(255, 107, 0, 0.2),
                -10px -10px 26px rgba(255, 255, 255, 0.85);
        }
        .card-header {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--orange-main);
            margin-bottom: 1.25rem;
            letter-spacing: 0.02em;
            user-select: none;
        }
        .card-body {
            flex-grow: 1;
            font-size: 1.2rem;
            color: var(--gray-dark);
            line-height: 1.55;
            margin-bottom: 2rem;
            user-select: text;
        }

        /* BUTTONS */
        .btn-primary {
            background: linear-gradient(90deg, var(--orange-main), var(--orange-light));
            border: none;
            padding: 1.1rem 0;
            border-radius: 35px;
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
            transition:
                background 0.4s ease,
                box-shadow 0.4s ease,
                transform 0.3s ease;
            user-select: none;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(90deg, var(--orange-dark), var(--orange-main));
            box-shadow: 0 12px 28px rgba(229, 91, 0, 0.7);
            transform: scale(1.05);
            outline: none;
        }
        .btn-primary:active {
            transform: scale(0.98);
            box-shadow: 0 6px 16px rgba(255, 107, 0, 0.35);
        }

        /* RESPONSIVO */
        @media (max-width: 720px) {
            .container {
                margin: 2rem auto 4rem;
                padding: 0 1rem;
            }
            .welcome-header {
                flex-direction: column;
                gap: 1.5rem;
                padding: 2rem 1.5rem;
                text-align: center;
            }
            .welcome-avatar {
                width: 90px;
                height: 90px;
            }
            .welcome-text h1 {
                font-size: 2.4rem;
            }
            .welcome-text p {
                font-size: 1.2rem;
            }
            .card {
                padding: 1.8rem 1.8rem;
            }
            .card-header {
                font-size: 1.4rem;
            }
            .card-body {
                font-size: 1.1rem;
                margin-bottom: 1.5rem;
            }
            .btn-primary {
                font-size: 1.15rem;
                padding: 1rem 0;
                border-radius: 30px;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container" role="main" aria-label="Painel do Usuário">
    <section class="welcome-header" aria-live="polite" aria-atomic="true">
        <img src="<?= htmlspecialchars($avatarBase64) ?>" alt="Avatar do Usuário" class="welcome-avatar" />
        <div class="welcome-text">
            <h1>Bem-vindo, <?= htmlspecialchars($Nome) ?>!</h1>
            <p>Seu painel de controle personalizado está aqui.</p>
        </div>
    </section>

    <section class="card" aria-labelledby="servicos-header">
        <h2 id="servicos-header" class="card-header">Serviços Recentes</h2>
        <p class="card-body">Acompanhe os serviços que você contratou recentemente com facilidade e rapidez.</p>
        <button class="btn btn-primary" onclick="window.location.href='Servicos.php'">Ver Meus Serviços</button>
    </section>

    <section class="card" aria-labelledby="solicitacoes-header">
        <h2 id="solicitacoes-header" class="card-header">Solicitações</h2>
        <p class="card-body">Confira suas solicitações pendentes e em andamento para manter tudo sob controle.</p>
        <button class="btn btn-primary" onclick="window.location.href='solicitar_servico.php'">Ver Solicitações</button>
    </section>

    <section class="card" aria-labelledby="perfil-header">
        <h2 id="perfil-header" class="card-header">Perfil e Configurações</h2>
        <p class="card-body">Atualize seus dados pessoais e preferências para uma experiência personalizada.</p>
        <button class="btn btn-primary" onclick="window.location.href='PerfilUser.php'">Configurações</button>
    </section>
</main>

</body>
</html>
