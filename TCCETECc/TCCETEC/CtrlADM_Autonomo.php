<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Autonomo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
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
</body>
</html>