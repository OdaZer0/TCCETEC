<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="auto">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Bootstrap + Icons + AOS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

  <!-- Estilo customizado -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #f0f4f8, #ffffff);
    }

    .form-wrapper {
      max-width: 700px;
      margin: 80px auto;
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .form-title {
      text-align: center;
      font-weight: 700;
      color: #18486b;
      margin-bottom: 30px;
    }

    .form-control:valid {
      border-color: #198754;
    }

    .form-control:invalid:focus {
      border-color: #dc3545;
    }

    .btn-custom {
      border-radius: 30px;
      font-weight: 500;
      padding: 10px 30px;
    }

    #alerta {
      display: none;
    }

    /* Estilo para mostrar força da senha */
    #forcaSenhaTexto {
      font-size: 12px;
      margin-top: 5px;
    }
  </style>
</head>

<body>

  <?php include 'header.php'; ?>

  <div class="form-wrapper" data-aos="zoom-in">
    <form id="formLogin" action="login.php" method="POST" novalidate>
      <h2 class="form-title"><i class="bi bi-person-lock"></i> Login</h2>

      <div id="alerta" class="alert" role="alert"></div>

      <div class="mb-3">
        <label class="form-label">Usuário</label>
        <input type="text" name="usuario" class="form-control" required maxlength="50" placeholder="Ex: João da Silva">
      </div>

      <div class="mb-3">
        <label class="form-label">Senha</label>
        <div class="input-group">
          <input type="password" name="senha" id="senha" class="form-control" required maxlength="250" placeholder="Digite sua senha">
          <button class="btn btn-outline-secondary" type="button" onclick="toggleSenha()">
            <i class="bi bi-eye" id="icone-senha"></i>
          </button>
        </div>
      </div>

      <div class="d-flex justify-content-center gap-3">
        <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-check-circle"></i> Entrar</button>
        <button type="reset" class="btn btn-outline-secondary btn-custom"><i class="bi bi-x-circle"></i> Limpar</button>
      </div>
    </form>
  </div>

  <?php include 'footer.php'; ?>

  <script>
    AOS.init({ duration: 800, once: true });

    // Mostrar/ocultar senha
    function toggleSenha() {
      const senhaInput = document.getElementById('senha');
      const icone = document.getElementById('icone-senha');
      const tipo = senhaInput.type === 'password' ? 'text' : 'password';
      senhaInput.type = tipo;
      icone.className = tipo === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
    }
  </script>

</body>

</html>
