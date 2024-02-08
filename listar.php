<?php

// Incluir a conexão com o banco de dados
include_once "conexao.php";

// Receber a página atual via método GET
$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

// Verificar se a página não está vazia
if (!empty($pagina)) {

    // Calcular o início de visualização
    $qnt_result_pg = 40; //Quantidade de registros por página
    $inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

    // Criar a QUERY para recuperar od registros BD
    $query_usuarios = "SELECT usr.id, usr.nome, usr.email,
                        ende.logradouro, ende.numero
                        FROM usuario AS usr
                        LEFT JOIN endereco AS ende ON ende.usuario_id=usr.id
                        ORDER BY usr.id DESC
                        LIMIT $inicio, $qnt_result_pg";
    $result_usuarios = $conn->prepare($query_usuarios);
    $result_usuarios->execute();

    // Verificar se há registros e se a consulta foi bem-sucedida
    if (($result_usuarios) and ($result_usuarios->rowCount() !=0)) {

        // Construir a tabela HTML com os resultados
        $dados = "<table class='table table-striped table-bordered teble-hover'>";
        $dados .="<thead>";
        $dados .="<tr>";
        $dados .="<th>ID</th>";
        $dados .="<th>Nome</th>";
        $dados .="<th>E-mail</th>";
        $dados .="<th>Logradouro</th>";
        $dados .="<th>Número</th>";
        $dados .="<th>Ações</th>";
        $dados .="</tr>";
        $dados .="</thead>";
        $dados .="</tbody>";
        while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
            extract($row_usuario);

            $dados .="<tr>";
            $dados .="<td>$id</td>";
            $dados .="<td>$nome</td>";
            $dados .="<td>$email</td>";
            $dados .="<td>$logradouro</td>";
            $dados .="<td>$numero</td>";
            $dados .="<td><a href='#' class='btn btn-outline-primary btn-sm' onclick='visUsuario($id)'>Visualizar</a> <a> href-'#' class='btn btn-outline-warming btn-sm' onclick='editUsusarioDados($id)'>Editar</a> <a href='#' class='btn btn-outline-danger btn-sm' onclick='apagarUsuarioDados($id)'>Apagar</a></td>";
            $dados .="</tr>";
        }
        $dados .="</tbody>";
        $dados .="</table>";

        // Paginacao - Somar a quantidade de registros que ha BD
        $query_pg = "SELECT COUNT(id) AS num_result FROM usuario";
        $result_pg = $conn->prepare($query_pg);
        $result_pg->execute();
        $row_pg = $result_pg->fetch(PDO:: FETCH_ASSOC);

        // Calcular
        $quantidade_pg = ceil(row_pg['num_result'] / $qnt_result_pg);

        $max_links = 2;

        // Construir a navegação da página
        $dados .= "<nav aria-label='Page navigation example'>";
        $dados .= ""
    }
}
