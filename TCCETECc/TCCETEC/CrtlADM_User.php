
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Usuários</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilos.css"> 
    <link rel="stylesheet" href="estilos2.css">
    <link rel="stylesheet" href="estilos3.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>

        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    text-align: center;
}

h2 {
    color: #d35400;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff3e0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

thead {
    background-color: #e67e22;
    color: white;
    font-weight: bold;
}

td, th {
    border: 1px solid #e67e22;
    padding: 10px;
    text-align: center;
}

tbody tr:nth-child(even) {
    background-color: #fde3a7;
}

tbody tr:hover {
    background-color: #f5b041;
    color: white;
}

button {
    background-color: #e67e22;
    color: white;
    border: none;
    padding: 8px 12px;
    margin: 5px;
    cursor: pointer;
    border-radius: 4px;
}

button:hover {
    background-color: #d35400;
}


    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <h2>Lista de Usuários</h2>
    <!-- Adicionando os botões de busca -->
    <h3>Pesquisar por CR</h3>
    <input type="text" id="searchCR" placeholder="Digite o CR para pesquisa" class="form-control" style="width: 20%; margin: 10px auto;">

    <!-- Botões para carregar os dados -->
        <button id="Btn_BuscarTodos" class="btn btn-primary">Buscar Todos</button>
    <button id="Btn_BuscarPorCR" class="btn btn-primary">Buscar por CR</button>

    <table border="1">
        <thead>
            <tr>
                <th>CR</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Avisos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="Tb_dados"></tbody>
    </table>

    <script>
        $(document).ready(function(){
    // Botão para buscar todos os usuários
    $("#Btn_BuscarTodos").click(function(){
        // Enviar requisição para buscar todos os usuários
        $.ajax({
            url: "BuscarUser.php",
            method: "POST",
            data: JSON.stringify({ 
                token: "meu_token_secreto" 
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(resposta){
                let tabela = "";
                resposta.forEach(function(usuario){
                    tabela += "<tr>";
                    tabela += "<td>" + usuario.cr + "</td>";
                    tabela += "<td>" + usuario.nome + "</td>";
                    tabela += "<td>" + usuario.email + "</td>";
                    tabela += "<td>" + usuario.avisos + "</td>";
                    tabela += "<td><button class='btnExcluir' data-cr='" + usuario.cr + "'>Excluir</button> </br> <button class = 'btn_PorAviso' data-cr = '" + usuario.cr + "'> Adicionar Aviso</button></td>";
                    tabela += "</tr>";
                });
                $("#Tb_dados").html(tabela);
            }
        });
    });

    // Botão para buscar por CR
    $("#Btn_BuscarPorCR").click(function(){
        var crPesquisa = $("#searchCR").val(); // Obtém o valor do campo de pesquisa
        
        if (crPesquisa.trim() === "") {
            alert("Por favor, digite um CR para buscar.");
            return; // Não continua com a requisição se o campo de CR estiver vazio
        }

        $.ajax({
            url: "BuscarUser.php",
            method: "POST",
            data: JSON.stringify({ 
                token: "meu_token_secreto", 
                cr: crPesquisa  // Passa o CR para filtrar a pesquisa
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(resposta){
                let tabela = "";
                resposta.forEach(function(usuario){
                    tabela += "<tr>";
                    tabela += "<td>" + usuario.cr + "</td>";
                    tabela += "<td>" + usuario.nome + "</td>";
                    tabela += "<td>" + usuario.email + "</td>";
                    tabela += "<td>" + usuario.avisos + "</td>";
                    tabela += "<td><button class='btnExcluir' data-cr='" + usuario.cr + "'>Excluir</button> </br> <button class = 'btn_PorAviso' data-cr = '" + usuario.cr + "'> Adicionar Aviso</button></td>";
                    tabela += "</tr>";
                });
                $("#Tb_dados").html(tabela);
            }
        });
    });

    // Delegação de evento para os botões "Excluir" e "Adicionar Aviso"
    $(document).on("click", ".btnExcluir", function(){
        let cr = $(this).data("cr");
        if(confirm("Tem certeza que deseja excluir este usuário?")) {
            $.ajax({
                url: "ExcluirUser.php",
                method: "POST",
                data: JSON.stringify({ cr: cr, token: "meu_token_secreto" }),
                contentType: "application/json",
                dataType: "json",
                success: function(resposta){
                    alert(resposta.mensagem);
                    $("#Btn_BuscarTodos").click(); // Recarrega a tabela após exclusão
                }
            });
        }
    });

    $(document).on("click",".btn_PorAviso", function(){
        let cr = $(this).data("cr");
        $.ajax({
            url: "PorAvisoUser.php",
            method: "POST",
            data: JSON.stringify({cr: cr, token: "meu_token_secreto"}),
            dataType: "json",
            success: function(resposta){
                alert(resposta.mensagem);
                // Recarregar dados após adicionar aviso
                $("#Btn_BuscarTodos").click();
            }
        });
    });
});

    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
