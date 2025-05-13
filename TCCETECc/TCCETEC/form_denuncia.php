<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denúncia ou Reclamação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu&display=swap" rel="stylesheet">

    <style>
        /* Estilos personalizados */
        body {
            font-family: 'Baloo Tammudu', cursive;
            background-color: #f4f7fc;
        }

        .custom-font {
            font-family: 'Baloo Tammudu', cursive;
            font-weight: bold;
            color: #343a40;
        }

        .form-control {
            border-radius: 10px;
            padding: 15px;
            font-size: 1rem;
        }

        .btn-outline-info {
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn-outline-info:hover {
            background-color: #17a2b8;
            color: white;
        }

        .btn-outline-danger {
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .form-text {
            font-size: 0.9rem;
        }

        .row.mt-4 {
            margin-top: 2rem;
        }

        /* Estilo para o card do formulário */
        .form-card {
            background-color: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 900px;
        }

        .alert-success,
        .alert-danger {
            margin-top: 20px;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="form-card">
            <h2 class="custom-font text-center">Denúncia ou Reclamação</h2>

            <!-- Exibindo mensagem de sucesso ou erro após o envio -->
            <?php
            if (isset($_SESSION['feedback'])) {
                echo '<div class="alert alert-' . $_SESSION['feedback']['type'] . '">' . $_SESSION['feedback']['message'] . '</div>';
                unset($_SESSION['feedback']);
            }
            ?>

            <form action="processar_denuncia.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="tipo" class="form-label">Tipo:</label>
                        <select name="tipo" id="tipo" class="form-control" required>
                            <option value="Denúncia de Usuário">Denúncia de Usuário</option>
                            <option value="Denúncia de Autônomo">Denúncia de Autônomo</option>
                            <option value="Denúncia Geral">Denúncia Geral</option>
                            <option value="Bug">Bug</option>
                            <option value="Sugestão">Sugestão</option>
                            <option value="Reclamação do Sistema">Reclamação do Sistema</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mb-3">
                        <label for="cr_acusado" class="form-label">CR do Acusado (se aplicável):</label>
                        <input type="number" name="cr_acusado" id="cr_acusado" class="form-control" placeholder="Ex: 123456">
                        <small class="form-text text-muted">Deixe em branco se não estiver denunciando uma pessoa.</small>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mb-3">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <textarea name="descricao" id="descricao" class="form-control" rows="5" required placeholder="Descreva sua denúncia ou sugestão com detalhes."></textarea>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-info me-2">Enviar</button>
                        <button type="reset" class="btn btn-outline-danger">Limpar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
