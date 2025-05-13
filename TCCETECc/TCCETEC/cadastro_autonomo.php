<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="auto">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Autônomo</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

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

    #forcaSenhaTexto {
      font-size: 12px;
      margin-top: 5px;
    }
  </style>
</head>

<body>

  <?php include 'header.php'; ?>

  <div class="form-wrapper" data-aos="zoom-in">
    <form id="formCadastro" action="Crtl_Autonomo.php" method="POST" enctype="multipart/form-data" novalidate>
      <h2 class="form-title"><i class="bi bi-person-lines-fill"></i> Cadastro de Autônomo</h2>

      <div id="alerta" class="alert" role="alert"></div>

      <div class="mb-3">
        <label class="form-label">Nome completo</label>
        <input type="text" name="nome" class="form-control" required maxlength="50" placeholder="Ex: João da Silva">
      </div>

      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required maxlength="60" placeholder="Ex: joao@email.com">
      </div>

      <div class="mb-3">
        <label class="form-label">Senha</label>
        <div class="input-group">
          <input type="password" name="senha" id="senha" class="form-control" required maxlength="250" placeholder="Crie uma senha segura">
          <button class="btn btn-outline-secondary" type="button" onclick="toggleSenha()">
            <i class="bi bi-eye" id="icone-senha"></i>
          </button>
        </div>
        <small id="forcaSenhaTexto" class="text-muted"></small>
      </div>

      <div class="mb-3">
        <label class="form-label">CPF</label>
        <input type="text" name="cpf" id="cpf" class="form-control" required maxlength="14" placeholder="000.000.000-00">
      </div>

      <div class="mb-3">
        <label class="form-label">CEP</label>
        <input type="text" name="cep" id="cep" class="form-control" required maxlength="9" placeholder="Ex: 12345-678">
      </div>

      <div class="mb-3">
        <label class="form-label">Rua</label>
        <input type="text" name="rua" id="rua" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Bairro</label>
        <input type="text" name="bairro" id="bairro" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Cidade</label>
        <input type="text" name="cidade" id="cidade" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Estado (UF)</label>
        <input type="text" name="uf" id="uf" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Área de atuação</label>
        <input type="text" name="area_atuacao" class="form-control" required maxlength="30" placeholder="Ex: Pedreiro, Eletricista...">
      </div>

      <div class="mb-4">
        <label class="form-label">Nível de formação</label>
        <input type="text" name="nvl_formacao" class="form-control" required maxlength="30" placeholder="Ex: Ensino Médio, Técnico...">
      </div>

      <div class="d-flex justify-content-center gap-3">
        <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-check-circle"></i> Cadastrar</button>
        <button type="reset" class="btn btn-outline-secondary btn-custom"><i class="bi bi-x-circle"></i> Limpar</button>
      </div>
    </form>
  </div>

  <?php include 'footer.php'; ?>

  <script>
    AOS.init({ duration: 800, once: true });

    const cpfInput = document.getElementById('cpf');
    cpfInput.addEventListener('input', function () {
      let v = this.value.replace(/\D/g, '');
      if (v.length > 3) v = v.replace(/^(\d{3})(\d)/, '$1.$2');
      if (v.length > 6) v = v.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
      if (v.length > 9) v = v.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
      this.value = v;
    });

    const cepInput = document.getElementById('cep');
    cepInput.addEventListener('input', function () {
      let v = this.value.replace(/\D/g, '');
      if (v.length > 5) v = v.replace(/^(\d{5})(\d)/, '$1-$2');
      this.value = v;
    });

    cepInput.addEventListener('blur', function () {
      const cep = this.value.replace(/\D/g, '');
      if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(res => res.json())
          .then(data => {
            if (data.erro) {
              showAlert('CEP não encontrado.', 'danger');
            } else {
              document.getElementById('rua').value = data.logradouro || '';
              document.getElementById('bairro').value = data.bairro || '';
              document.getElementById('cidade').value = data.localidade || '';
              document.getElementById('uf').value = data.uf || '';
              showAlert(`CEP válido: ${data.localidade} - ${data.uf}`, 'success');
            }
          }).catch(() => {
            showAlert('Erro ao buscar CEP.', 'danger');
          });
      }
    });

    function toggleSenha() {
      const senhaInput = document.getElementById('senha');
      const icone = document.getElementById('icone-senha');
      const tipo = senhaInput.type === 'password' ? 'text' : 'password';
      senhaInput.type = tipo;
      icone.className = tipo === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
    }

    // Força da senha
    document.getElementById('senha').addEventListener('input', function () {
      const val = this.value;
      const forcaTexto = document.getElementById('forcaSenhaTexto');
      const forte = /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])/;

      if (val.length < 6) {
        forcaTexto.textContent = 'Muito fraca';
        forcaTexto.className = 'text-danger';
      } else if (!forte.test(val)) {
        forcaTexto.textContent = 'Média (adicione números, maiúsculas e símbolos)';
        forcaTexto.className = 'text-warning';
      } else {
        forcaTexto.textContent = 'Forte';
        forcaTexto.className = 'text-success';
      }
    });

    function showAlert(msg, type) {
      const alertBox = document.getElementById('alerta');
      alertBox.className = `alert alert-${type}`;
      alertBox.innerText = msg;
      alertBox.style.display = 'block';
      setTimeout(() => alertBox.style.display = 'none', 5000);
    }
  </script>
</body>

</html>
