<?php

    //Realizar a conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara um array de retorno vazio
    $dados = array();

    //Verifica se existem uma conexão
    if($conexao){

        //Obtém os dados via post
        $RequestData = $_REQUEST;

        //Verifica se está vindo o idcategoria, caso não esteja o idCategoria será '' vazio
        $idCategoria = isset($RequestData['idcategoria']) ? $RequestData['idcategoria'] : '';

        //Prepara o comando select
        $sql = "SELECT n.idnoticia, date_format(n.data_noticia,'%d/%m/%Y %H:%i:%s') as data_noticia, 
        n.titulo, n.corpo, n.imagem, n.idcategoria, c.nome as categoria
        FROM NOTICIAS n
        INNER JOIN CATEGORIAS c ON c.idcategoria = n.idcategoria ";

        //Verifica se veio o idCategoria, caso sim, acrescenta a cláusula WHERE
        //para realizar o filtro das notícias
        if(!empty($idCategoria)){
            $sql .= " WHERE n.idcategoria='$idCategoria' ";
        }

        //Comprlementa com o comando SELECT com a cláusula ORDER BY para ordenar
        //e limitar a quantidade notícias retornadas
        $sql .= " ORDER BY n.data_noticia desc LIMIT 6";
        
        //Executa o comando
        $resultado = mysqli_query($conexao, $sql);

        //Caso tenha um resultado satisfatório
        if($resultado){
            
            //Obtém os dados da noticia
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);