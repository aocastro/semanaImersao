<?php

    //obtém uma conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara o array de retorno caso não tenha uma conexão com o banco
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    //Verifica se existem uma conexão
    if($conexao){

        //Obtém os dados via post
        $requestData = $_REQUEST;

        //Verifica se está vindo o idcomentario, caso não esteja o idComentario será '' vazio
        $idComentario = isset($requestData['idcomentario']) ? $requestData['idcomentario'] : '';

        //Prepara o comando select
        $sql = "SELECT c.idcomentario, date_format(c.data_comentario,'%d/%m/%Y %H:%i:%s') as data_comentario, c.comentario, c.idnoticia, c.idusuario, u.nome as usuario
        FROM COMENTARIOS c
        INNER JOIN USUARIOS u ON u.idusuario = c.idusuario
        WHERE idcomentario=$idComentario";
        
        //Executa o comando
        $resultado = mysqli_query($conexao,$sql);

        //Caso tenha um resultado satisfatório
        if($resultado){

            //Obtém os dados do comentário
            $dadosComentario = array();
            while($row = mysqli_fetch_assoc($resultado)){
                $dadosComentario = array_map('utf8_encode', $row);
            }

            //Prepara o array de retorno com sucesso
            $dados = array(
                'tipo' => 'success',
                'mensagem' => '',
                'dados' => $dadosComentario
            );
        } else{ //Caso não tenha um resultado satisfatório

            //Prepara o array de retorno com erro
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível obter o comentário.',
                'dados' => array()
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);