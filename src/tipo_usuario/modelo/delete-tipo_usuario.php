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

        //Verifica se está vindo o itipo_dusuario, caso não esteja o idTipoUsuario será '' vazio
        $idTipoUsuario = isset($requestData['idtipo_usuario']) ? $requestData['idtipo_usuario'] : '';

        //Prepara o comando delete
        $sql = "DELETE FROM TIPOS_USUARIOS WHERE idtipo_usuario=$idTipoUsuario";

        //Executa o comando
        $resultado = mysqli_query($conexao, $sql);

        //Caso tenha um resultado satisfatório
        if($resultado){

            //Prepara o array de retorno com sucesso
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Tipo de usuário deletado com sucesso.'
            );
        } else{ //caso contrário, prepara um array de retorno com erro
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível deletar o tipo de usuário.'
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);