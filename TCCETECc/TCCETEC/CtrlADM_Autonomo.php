
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
    color: blue;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: lightblue;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

thead {
    background-color: lightblue;
    color: white;
    font-weight: bold;
}

td, th {
    border: 1px solid blue;
    padding: 10px;
    text-align: center;
}

tbody tr:nth-child(even) {
    background-color: lightblue;
}

tbody tr:hover {
    background-color: lightblue;
    color: white;
}

button {
    background-color: blue;
    color: white;
    border: none;
    padding: 8px 12px;
    margin: 5px;
    cursor: pointer;
    border-radius: 4px;
}

button:hover {
    background-color: blue;
}


    </style>
</head>
<body>
<?php include 'header.php'; ?>
<body>
    <h2>Lista de Autonomos</h2>
    <button id="Btn_Carregar">Carregar Dados</button>
    <table border = "1">
        <thead>
            <tr>
                <th>CR</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Avisos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id= "Tb_dados"></tbody>
    </table>
    <script>
        $(document).ready(function(){
            $("#Btn_Carregar").click(function(){
                $.ajax({
                    url: "BuscarAutonomo.php",
                    method: "POST",
                    data: JSON.stringify({token: "meu_token_secreto"}),
                    contentType: "application/json",
                    dataType: "json",
                    success: function(resposta){
                        let tabela = "";
                        resposta.forEach(function(autonomo){
                            tabela += "<tr>";
                            tabela += "<td>" + autonomo.cr + "</td>";
                            tabela += "<td>" + autonomo.nome + "</td>";
                            tabela += "<td>" + autonomo.email + "</td>";
                            tabela += "<td>" + autonomo.avisos + "</td>";
                            tabela += "<td><button class='btnExcluir' data-cr='" + autonomo.cr + "'>Excluir</button> </br> <button class = 'btn_PorAviso' data-cr = '" + autonomo.cr + "'> Adicionar Aviso</button></td>";
                            tabela += "</tr>";
                        });
                        $("#Tb_dados").html(tabela);

                    }
                });
            });
            $(document).on("click", ".btnExcluir", function(){
                let cr = $(this).data("cr"); // Obtém o CR do botão clicado
                
                if(confirm("Tem certeza que deseja excluir este usuário?")) {
                    $.ajax({
                        url: "ExcluirAutonomo.php",
                        method: "POST",
                        data: JSON.stringify({ cr: cr, token: "meu_token_secreto" }),
                        contentType: "application/json",
                        dataType: "json",
                        success: function(resposta){
                            alert(resposta.mensagem);
                            $("#Btn_Carregar").click(); // Recarrega a tabela após exclusão
                        }
                    });
                }
            });
        });
        $(document).on("click",".btn_PorAviso", function(){
    let cr = $(this).data("cr");
    $.ajax({
        url: "PorAvisoAutonomo.php",
        method: "POST",
        data: JSON.stringify({cr: cr, token: "meu_token_secreto"}),
        dataType: "json",
        success: function(resposta){
            alert(resposta.mensagem);

            // Carregar os dados novamente para atualizar a tabela
            $.ajax({
                url: "BuscarAutonomo.php",
                method: "POST",
                data: JSON.stringify({ token: "meu_token_secreto" }),
                contentType: "application/json",
                dataType: "json",
                success: function(resposta){
                    let tabela = "";
                    resposta.forEach(function(autonomo){
                        tabela += "<tr>";
                        tabela += "<td>" + autonomo.cr + "</td>";
                        tabela += "<td>" + autonomo.nome + "</td>";
                        tabela += "<td>" + autonomo.email + "</td>";
                        tabela += "<td>" + autonomo.avisos + "</td>";
                        tabela += "<td><button class='btnExcluir' data-cr='" + autonomo.cr + "'>Excluir</button> </br> <button class = 'btn_PorAviso' data-cr = '" + autonomo.cr + "'> Adicionar Aviso</button></td>";
                        tabela += "</tr>";
                    });
                    $("#Tb_dados").html(tabela); // Atualiza a tabela com os dados mais recentes
                }
            });
        }
    });
});
    
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>