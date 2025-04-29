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
</head>

<body>
<?php include 'header.php'; ?>

<div class="container">
    <form action="processar_denuncia.php" method="POST" class="form">
        <h2 class="d-flex custom-font justify-content-center">Denúncia ou Reclamação</h2>

        <div class="row">
            <div class="col-md-12">
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
            <div class="col-md-12">
                <label for="cr_acusado" class="form-label">CR do Acusado (se aplicável):</label>
                <input type="number" name="cr_acusado" id="cr_acusado" class="form-control" placeholder="Ex: 123456">
                <small class="form-text text-muted">Deixe em branco se não estiver denunciando uma pessoa.</small>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
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

<?php include 'footer.php'; ?>
</body>

</html>
