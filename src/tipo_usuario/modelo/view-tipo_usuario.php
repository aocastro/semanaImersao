<?php

    //Verifica se existem uma conexão
    include('../../conexao/conexao.php');

    //Prepara o array de retorno caso não tenha uma conexão com o banc
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    //Verifica se existem uma conexão
    if($conexao){

        //Obtém os dados via post
        $requestData = $_REQUEST;

        //Verifica se está vindo o idtipo_usuario, caso não esteja o idTipoUsuario será '' vazio
        $idTipoUsuario = isset($requestData['idtipo_usuario']) ? $requestData['idtipo_usuario'] : '';

        //Prepara o comando select
        $sql = "SELECT idtipo_usuario, nome, tipo FROM TIPOS_USUARIOS 
                WHERE idtipo_usuario=$idTipoUsuario";
        
        //Executa o comando
        $resultado = mysqli_query($conexao,$sql);

        //Caso tenha um resultado satisfatório
        if($resultado){

            //Obtém os dados do usuário
            $dadosTipo = array();
            while($row = mysqli_fetch_assoc($resultado)){
                $dadosTipo = array_map('utf8_encode', $row);
            }

            //Prepara o array de retorno com sucesso
            $dados = array(
                'tipo' => 'success',
                'mensagem' => '',
                'dados' => $dadosTipo
            );
        } else{ //Caso não tenha um resultado satisfatório

            //Prepara o array de retorno com erro
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível obter o tipo de usuário.',
                'dados' => array()
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);