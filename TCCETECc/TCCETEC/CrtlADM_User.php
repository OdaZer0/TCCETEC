<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Usuários</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Lista de Usuários</h2>
    <button id="Btn_Carregar">Carregar Dados</button>
    <table border="1">
        <thead>
            <tr>
                <th>CR</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="Tb_dados"></tbody>
    </table>

    <script>
        $(document).ready(function(){
            // Carregar dados
            $("#Btn_Carregar").click(function(){
                $.ajax({
                    url: "BuscarUser.php",
                    method: "POST",
                    data: JSON.stringify({ token: "meu_token_secreto" }), 
                    contentType: "application/json",
                    dataType: "json",
                    success: function(resposta){
                        let tabela = "";
                        resposta.forEach(function(usuario){
                            tabela += "<tr>";
                            tabela += "<td>" + usuario.cr + "</td>";
                            tabela += "<td>" + usuario.nome + "</td>";
                            tabela += "<td>" + usuario.email + "</td>";
                            tabela += "<td><button class='btnExcluir' data-cr='" + usuario.cr + "'>Excluir</button></td>";
                            tabela += "</tr>";
                        });
                        $("#Tb_dados").html(tabela);
                    }
                });
            });

            // Delegação de evento para os botões "Excluir"
            $(document).on("click", ".btnExcluir", function(){
                let cr = $(this).data("cr"); // Obtém o CR do botão clicado
                
                if(confirm("Tem certeza que deseja excluir este usuário?")) {
                    $.ajax({
                        url: "ExcluirUser.php",
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
    </script>
</body>
</html>
