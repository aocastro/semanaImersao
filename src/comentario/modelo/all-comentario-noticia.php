<?php

    //Realizar a conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara o objeto de retorno vazio
    $dados = array();

    //Verifica se existem uma conexão
    if($conexao){

        //obtém os dados via post
        $requestData = $_REQUEST;

        //Verifica se está vindo o idnoticia, caso não esteja o idNoticia será '' vazio
        $idNoticia = isset($requestData['idnoticia']) ? $requestData['idnoticia'] : '';

        //Prepara o comando select
        $sql = "SELECT c.idcomentario, date_format(c.data_comentario,'%d/%m/%Y %H:%i:%s') as data_comentario, c.comentario, c.idnoticia, c.idusuario, u.nome as usuario
        FROM COMENTARIOS c
        INNER JOIN USUARIOS u ON u.idusuario = c.idusuario
        WHERE c.idnoticia=$idNoticia
        ORDER BY c.idnoticia";

        //Executa o comando
        $resultado = mysqli_query($conexao, $sql);

        //Caso tenha um resultado satisfatório
        if($resultado){
            
            //Obtém os dados do comentario
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);