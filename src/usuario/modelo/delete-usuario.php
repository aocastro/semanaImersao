<?php

    //Verifica se existem uma conexão
    include('../../conexao/conexao.php');

    //Prepara o array de retorno caso não tenha uma conexão com o banco
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.'
    );

    //Verifica se existem uma conexão
    if($conexao){

        //Obtém os dados via post
        $requestData = $_REQUEST;

        //Verifica se está vindo o idusuario, caso não esteja o idUsuario será '' vazio
        $idUsuario = isset($requestData['idusuario']) ? $requestData['idusuario'] : '';

        //Prepara o comando delete
        $sql = "DELETE FROM USUARIOS WHERE idusuario=$idUsuario";

        //Executa o comando
        $resultado = mysqli_query($conexao, $sql);

        //Caso tenha um resultado satisfatório
        if($resultado){

            //Prepara o array de retorno com sucesso
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Usuário deletado com sucesso.'
            );
        } else{ //caso contrário, prepara um array de retorno com erro
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível deletar o usuário.'
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);